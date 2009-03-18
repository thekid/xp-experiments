<?php
/**
 * This file is part of moepbot.
 * @version $Id: moep.php,v 1.9 2009/03/15 14:10:20 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * $Id: moep.php,v 1.9 2009/03/15 14:10:20 schlind Exp $
 *
 * @package     org.schlind.moepbot.scripts
 * @version     1.0 $Revision: 1.9 $
 * @author      Sascha Schlindwein <moepbot@schlind.org>
 */
if (self::isInit()) {
	self::log('[moep] $Id: moep.php,v 1.9 2009/03/15 14:10:20 schlind Exp $');
	self::log('[moep] channels: '.self::getConfigValue('moep.channels'));
	self::log('[moep] commands: !time !date !moep +moep -moep');
}

else if (self::isHeartBeat()) {
	if (self::getConfigValue('moep.sleeping')) {
		$now = date('Hi');
		$isDaylight = 930 < $now && 2330 > $now;
		#self::log("isDaylight=$isDaylight, $now");
		if ($isDaylight && self::getEnv('moep.sleeping')) {
			// sleeping..
			self::log('[moep] waking up...');
			self::setEnv('moep.sleeping', false);
			#self::changeNick(self::getConfigValue('bot.nickname'));
			self::setAway();
		} else if (!$isDaylight && !self::getEnv('moep.sleeping')){
			self::log('[moep] falling asleep...');
			self::setEnv('moep.sleeping', true);
			#self::changeNick(self::getMyNick().'|zZz');
			self::setAway('chhhhhrrrr...');
		}
	}
}

else if (self::isHelpTriggered()) {
	// global help
	self::sendMessage(self::getSourceNick(),
	'[moep] Fuer weitere Hilfe gib "?moep" ein');
}

elseif (self::isHelpTriggered('?moep')) {
	// help message
	self::sendAction(self::getSourceNick(),
	'Dieses Script funktioniert nur in Kanaelen, nicht im Query.');
	self::sendMessage(self::getSourceNick(),
	'"!moep", "!+moep ", "!-moep"');
}


else if (self::isInvite()) {
	// let the bot join channels on invite
	$invitedTo   = self::getMessage();
	$invitedFrom = self::getSourceNick();
	self::log("[moep] I am invited to $invitedTo by $invitedFrom");
	if (self::getConfigValue('moep.joinOnInvite')) {
		self::log("[moep] Joining $invitedTo...");
		self::joinChannel($invitedTo);
		self::sendMessage($invitedTo, "ich bin wegen $invitedFrom hier!");
	}
}

else if (self::isMode() && self::isOnMe()) {
	if (strstr(self::getMode(), '+o')) {
		self::setChannelMode(self::getTargetChannel(), '-o', self::getMyNick());
		self::sendAction(self::getTargetChannel(), 'will kein op sein');
	}
	if (strstr(self::getMode(), '+v')) {
		self::sendAction(self::getTargetChannel(), 'hat nix zu sagen');
	}
}

else if (self::isPrivmsg() 
&& self::isOnChannel(self::getConfigList('moep.channels'))) {

	$sourceNick = self::getSourceNick();
	$targetChan = self::getTargetChannel();
	$message    = self::getMessage();
	$moepFile   = self::getConfigValue('bot.name').'-moep.array';

	if (self::isCommand('time')||self::isCommand('date')) {
		self::sendMessage($targetChan, ''.date('d.m.Y H:i:s'));
	}

	else if (self::isCommand('moep')) {

		$moepTo = self::getMessage();

		if (empty($moepTo)) { $moepTo = $sourceNick; }
		$moeps =& MoepUtil::getArray($moepFile);

		if (is_array($moeps) && 0 < count($moeps)) {
			$moep = $moeps[array_rand($moeps)];
			if (empty($moepTo)) { $moepTo = $sourceNick; }
			$moep = str_replace('XXX', $moepTo, $moep);
			self::sendMessage($targetChan, $moep);
		} else {
			self::sendAction($targetChan, "hat kein moep");
		}

	}

	else if (self::isCommand('+moep')
	|| self::isCommand('+moep', true)) {

		$newMoep = self::getMessage();
		if (false===strpos($newMoep, 'XXX')) {
			self::sendMessage($targetChan,
	    "$sourceNick, Du machst es falsch. Deine Eingabe moep muss irgendwo den Platzhalter XXX enthalten!");
		} else {
			$moeps =& MoepUtil::getArray($moepFile);
			$moeps[] = $newMoep;
			$countMoeps = count($moeps);
			self::sendAction($targetChan,
			"hat jetzt $countMoeps moeps, dank $sourceNick");
		}
	}

	else if (self::isCommand('-moep')
	|| self::isCommand('-moep', true)) {

		$moepTo = self::getMessage();
		if (false===strpos($newMoep, 'XXX')) {
			self::sendMessage($targetChan,
	    "$sourceNick, Du machst es falsch. Deine Eingabe moep muss irgendwo den Platzhalter XXX enthalten!");
		} else {
			$moeps =& MoepUtil::getArray($moepFile);
			$countMoepsBefore = count($moeps);
			$moeps = array_diff($moeps,array($moepTo));
			$countMoeps = count($moeps);
			if ($countMoepsBefore > $countMoeps) {
				self::sendMessage($targetChan,
			"hat jetzt $countMoeps moeps, dank $sourceNick");
			} else {
				self::sendMessage($targetChan,"?");
			}
		}
	}
}
?>
