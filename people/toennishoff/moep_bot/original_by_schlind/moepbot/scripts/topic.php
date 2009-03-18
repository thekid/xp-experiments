<?php
/**
 * This file is part of moepbot.
 * @version $Id: topic.php,v 1.5 2009/03/15 16:08:29 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * $Id: topic.php,v 1.5 2009/03/15 16:08:29 schlind Exp $
 *
 * This script allows users to simply change the topic without losing previous
 * topics.
 *
 * This script can be activated in the config file with
 *
 * To protect a topic from being changed (hard-protection)
 *  topic.protect.#channel=[true|false]
 * To protect a topic from being lost (soft-protection)
 *  topic.prepend.#channel=[true|false]
 *
 * @package net.moep.irc
 * @version $Revision: 1.5 $
 * @author Sascha Schlindwein <phpbot@schlind.org>
 */
if (self::isInit()) {
	// init-phase
} else if (self::isHeartBeat()) {

} else if (self::isNumeric() && 332 == self::getMsgType()) {
	// 332 RPL_TOPIC RFC1459 <channel> :<topic>
	// 332 RPL_TOPIC RFC2812 <channel> :<topic> - When sending a TOPIC message to
	//
	// This message contains the topic of a joined channel.
	// determine the channel topic, one of two replies is sent. If the topic is
	// set, RPL_TOPIC is sent back else RPL_NOTOPIC.
	// -----------------------------------------------------------------------------
	$parts = self::getMessage();
	$parts = explode(':', $parts);
	$targetChans = array_shift($parts);
	$topic = array_shift($parts);
	$targetChans = explode(' ', $targetChans);
	array_shift($targetChans);
	$targetChan  = array_shift($targetChans);
	self::log("$targetChan Current topic is '$topic'");

	$_db =& MoepUtil::getArray("topic.$targetChan");
	$_db['topic'] = $topic;

} else if (self::isNumeric() && 333 == self::getMsgType()) {
	// -----------------------------------------------------------------------------
	// 333 is not specified in RFC
	// This message contains more information on a topic of a joined channel.
	// -----------------------------------------------------------------------------
	$parts = self::getMessage();
	$parts = explode(' ', $parts);
	array_shift($parts);
	$targetChan = array_shift($parts);
	$from = array_shift($parts);
	$time = array_shift($parts);
	$time = date('d.m.Y H:i:s', $time);
	self::log("$targetChan Current topic was set by '$from' on '$time'");
	 
	$_db =& MoepUtil::getArray("topic.$targetChan");
	$_db['setby'] = $from;
	$_db['seton'] = $time;

} else if (self::isTopic() && self::isFromUser()) {

	$MAXTOPICLEN = self::getServerSupport('TOPICLEN',300);

	// Someone sets a new topic on a channel
	$sourceNick = self::getSourceNick();
	$targetChan = self::getTargetChannel();
	$newTopic   = self::getMessage();

	$_db =& MoepUtil::getArray("topic.$targetChan");
	$oldTopic     = isset($_db['topic']) ? $_db['topic'] : '';
	$oldTopicBy   = isset($_db['setby']) ? $_db['setby'] : '';
	$oldTopicTime = isset($_db['seton']) ? $_db['seton'] : '';

	#self::log("OLD TOPIC $oldTopic, $oldTopicBy, $oldTopicTime");
	#self::log("NEW TOPIC $newTopic");

	$protectTopic = self::getConfigValue("topic.protect.$targetChan");
	self::log("topic.protect.$targetChan=$protectTopic");
	$prependTopic = self::getConfigValue("topic.prepend.$targetChan");
	self::log("topic.prepend.$targetChan=$prependTopic");

	if (!self::isMe() && $protectTopic) {

		// protect, reset the previous topic
		self::setTopic($targetChan, $oldTopic);
		self::sendMessage($targetChan,
        "Dieses Topic ist geschützt, bitte verwende !topic <deinTopic>");

	} else if (!self::isMe() && $prependTopic) {

		// prepend the new topic to the old one
		$oldTopic = trim($oldTopic);
		if (empty($oldTopic) || $newTopic == $oldTopic) return;

		$newTopic = str_replace('|','',$newTopic);
		$newTopic = str_replace($oldTopic,'',$newTopic);

		$newTopic = "$newTopic | $oldTopic";

		if ($MAXTOPICLEN<strlen($newTopic))
		$newTopic = substr($newTopic, 0, $MAXTOPICLEN).'...';

		self::sendAction($targetChan, "fix0rt das topic.. *bastel*");
		self::setTopic($targetChan, $newTopic);

		$_db =& MoepUtil::getArray("topic.$targetChan");
		$_db['topic'] = $newTopic;
		$_db['setby'] = $sourceNick;
		$_db['seton'] = date('d.m.Y H:i:s');

	} else {

		// just remember the topic change
		$_db =& MoepUtil::getArray("topic.$targetChan");
		$_db['topic'] = $newTopic;
		$_db['setby'] = $sourceNick;
		$_db['seton'] = date('d.m.Y H:i:s');
	}

} else if (self::isPrivmsg() && self::isOnChannel()) {

	$MAXTOPICLEN = self::getServerSupport('TOPICLEN');

	$sourceNick = self::getSourceNick();
	$targetChan = self::getTargetChannel();


	if (self::isCommand('settopic')) {

		$newTopic = self::getMessage();

		self::setTopic($targetChan, $newTopic);

		$_db =& MoepUtil::getArray("topic.$targetChan");
		$_db['topic'] = $newTopic;
		$_db['setby'] = $sourceNick;
		$_db['seton'] = date('d.m.Y H:i:s');

	} else if (self::isCommand('topic')) {

		$newTopic = self::getMessage();
		$_db =& MoepUtil::getArray("topic.$targetChan");
		$oldTopic     = isset($_db['topic']) ? $_db['topic'] : '';
		$oldTopicBy   = isset($_db['setby']) ? $_db['setby'] : '';
		$oldTopicTime = isset($_db['seton']) ? $_db['seton'] : '';

		if (empty($newTopic)) {

			// dump info about the current topic
			self::sendMessage($targetChan,
                "Dieses Topic ist von $oldTopicBy ($oldTopicTime)");


		} else {

			// prepend the new topic to the old one
			$newTopic = str_replace('|','',$newTopic);
			$oldTopic = trim($oldTopic);
			if (!empty($oldTopic)) $newTopic = "$newTopic | $oldTopic";
			if ($MAXTOPICLEN<strlen($newTopic)) {
				$newTopic = substr($newTopic, 0, $MAXTOPICLEN).'...';
			}

			#self::sendMessage($targetChan, "*bastel*");
			self::setTopic($targetChan, $newTopic);

			$_db =& MoepUtil::getArray("topic.$targetChan");
			$_db['topic'] = $newTopic;
			$_db['setby'] = $sourceNick;
			$_db['seton'] = date('d.m.Y H:i:s');
		}

	} else if (self::isCommand('-topic')) {

		$_db =& MoepUtil::getArray("topic.$targetChan");
		$oldTopic     = isset($_db['topic']) ? $_db['topic'] : '';
		$oldTopicBy   = isset($_db['setby']) ? $_db['setby'] : '';
		$oldTopicTime = isset($_db['seton']) ? $_db['seton'] : '';

		$delTopicNrs = self::getMessage();
		$topicParts = explode('|', $oldTopic);

		if (empty($delTopicNrs)) {
			$i = 0;
			$newtop = '';
			self::sendMessage($targetChan,
            "Das aktuelle Topic kann in ".sizeof($topicParts)
			." Teile zerlegt werden:");

			foreach ($topicParts as $part) {
				$i++;
				$part = trim($part);
				self::sendMessage($targetChan,
                    "$i: (".strlen($part)." Zeichen): $part");
			}
			self::sendMessage($targetChan,
            "Beispiel: Löschen des 3. Teils mit '!-topic 3' oder '!-topic 2,3,5'");

		} else {

			$delTopicNrs = explode(',', $delTopicNrs);
			$delTopicNrs = array_flip($delTopicNrs);
			#print_r($delTopicNrs);

			self::sendMessage($targetChan, "*bastel*");

			$i = 0;
			$size = sizeof($topicParts);
			$hadFirst = false;
			$newTopic = '';
			foreach ($topicParts as $part) {
				$i++;
				if (array_key_exists($i, $delTopicNrs) ) {
					// delete
					#print "deleting $i\n";
					continue;
				} else {
					// delete not
					#print "keeping $i\n";
					$part = trim($part);
					if (empty($part)) continue;

					if (1 == $i || !$hadFirst)  {
						$newTopic = $part;
						$hadFirst = true;
					}
					else {
						$newTopic = "$newTopic | $part";
					}
				}
			}

			self::setTopic($targetChan, $newTopic);

			$_db =& MoepUtil::getArray("topic.$targetChan");
			$_db['topic'] = $newTopic;
			$_db['setby'] = $sourceNick;
			$_db['seton'] = date('d.m.Y H:i:s');
		}
	}
}
?>
