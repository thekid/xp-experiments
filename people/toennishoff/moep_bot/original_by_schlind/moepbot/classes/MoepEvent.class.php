<?php
/**
 * This file is part of moepbot.
 * @version $Id: MoepEvent.class.php,v 1.9 2009/03/15 15:45:09 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * MoepEvent describes an incoming irc-event.
 * @package net.moep.irc
 * @version 1.0 ($Revision: 1.9 $)
 * @author Sascha 'lupo' Schlindwein <schlind@moep.net>
 */
final class MoepEvent {

	// Constants
	// -------------------------------------------------------------------------
	
	const UNDEFINED    = 'UNDEFINED';
	const TYPE_NUMERIC = 'TYPE_NUMERIC';
	const TYPE_PRIVMSG = 'TYPE_PRIVMSG';
	const TYPE_NOTICE  = 'TYPE_NOTICE';
	const TYPE_ACTION  = 'TYPE_ACTION';
	const TYPE_CTCP    = 'TYPE_CTCP';
	const TYPE_NICK    = 'TYPE_NICK';
	const TYPE_INVITE  = 'TYPE_INVITE';
	const TYPE_TOPIC   = 'TYPE_TOPIC';
	const TYPE_MODE    = 'TYPE_MODE';
	const TYPE_JOIN    = 'TYPE_JOIN';
	const TYPE_PART    = 'TYPE_PART';
	const TYPE_KICK    = 'TYPE_KICK';
	const TYPE_QUIT    = 'TYPE_QUIT';
	const FROM_SERVER  = 'FROM_SERVER';
	const FROM_USER    = 'FROM_USER';
	const ON_PRIVATE   = 'ON_PRIVATE';
	const ON_CHANNEL   = 'ON_CHANNEL';
	const TO_NICK      = 'TO_NICK';
	const TO_CHANNEL   = 'TO_CHANNEL';

	// Members
	// -------------------------------------------------------------------------
	
	private $moepIrc       = null;
	
	private $eventType     = self::UNDEFINED; // one of TYPE_
	private $eventFrom     = self::UNDEFINED; // one of FROM_
	private $eventOn       = self::UNDEFINED; // one of ON_
	private $eventTo       = self::UNDEFINED; // one of TO_
	private $eventSource   = null;
	private $eventTarget   = null;
	private $eventMsgType  = null;
	private $eventMessage  = null;

	private $isMe          = false;
	private $isOnMe        = false;

	private $sourceNick    = null;
	private $sourceUser    = null;
	private $sourceHost    = null;
	private $sourceServer  = null;

	private $targetChannel = null;
	private $targetNick    = null;

	private $inMode        = null;
	private $modeTo        = null;

	private $ctcpType      = null;
	private $botNick       = null;

	private $currentCommand = null;

	// Constructor
	// -------------------------------------------------------------------------
	
/**
	 * This is the default constructor.
	 *
	 * @internal Process parsing
	 *
	 * @param MoepIrc $moepIrc The connection to the server.
	 * @param string $rawEvent The raw event.
	 */
	public final function MoepEvent(MoepIrc &$moepIrc, $rawEvent) {

		$this->botNick = $moepIrc->getMyNick();
		$this->moepIrc = $moepIrc;

		// Begin parsing
		$this->log("==== NEW EVENT");
		$this->log("$rawEvent");

		// Trim leading : if exists and
		if (':' == $rawEvent[0]) { $rawEvent = substr($rawEvent,1); }

		// Transform the raw message into an array.
		// This splits the message into 3 general parts.
		$rawEvent       = explode(' ', $rawEvent);

		// The order of the following method-calls *does* matter!

		//  Part 1  ->  The from-part tells us where the message comes from.
		//              This can either be the hostname of a server or the
		//              full usermask of an irc-user.
		//
		$this->parseSource(isset($rawEvent[0]) ? $rawEvent[0] : null);

		//  Part 2  ->  The command-part contains the type of the command in
		//              message. This can either be a numeric value or a
		//              string like 'PRIVMSG' or 'MODE' and so on.
		//
		$this->parseMsgType(isset($rawEvent[1]) ? $rawEvent[1] : null);

		//  Part 3  ->  The target-part
		//              If this is a server-message, the array contains
		//              further message-content in elements 2 to end.
		//              If this is a user-message, the array contains
		//              the spoken words in elements 3 to end.
		//
		$this->parseTarget(isset($rawEvent[2]) ? $rawEvent[2] : null);

		//  Part 4   -> Now we fetch the information nested in the several
		//              parts collected above.
		$this->parseMessage($rawEvent);
		$this->parseKick();
		$this->parseMode();
		$this->parseCtcp();

		$this->log(
        "$this->eventType=>$this->eventOn=>$this->eventFrom=>$this->eventTo");
		$this->log("MESSAGE $this->eventMessage");
		$this->log("==== END EVENT");
	}

	// Interna
	// -------------------------------------------------------------------------
	
	/**
	 * This method writes a message to the log.
	 * @param string $message The message.
	 */
	private final function log($message) {
		MoepUtil::log("MoepEvent $message");
	}

	/**
	 * This method parses the source of the event.
	 *
	 * @internal The source can be one of the following types:
	 * "me" - when the bot triggers an event
	 * "nick" - some other nick triggers an event.
	 * "server" - a connected server triggers an event.
	 */
	private final function parseSource($source) {

		$source = trim($source);
		$this->log("FROM SOURCE $source");
		$this->eventSource = trim($source);

		#print "\n\n $source  == ".$this->moepIrc->getMe()."\n\n";

		if (preg_match('/(.*)!(.*)@(.*)/', $source, $match)) {
			// this is an event from a user
			// we expect <nick>!<user>@<host>
			$this->eventFrom = (self::FROM_USER);
			array_shift($match);
			$this->sourceNick = array_shift($match);
			$this->sourceUser = array_shift($match);
			$this->sourceHost = array_shift($match);

			if ($this->botNick == $this->sourceNick) {
				$this->isMe = true;
				$this->sourceNick = $this->botNick;
				$this->log("SOURCE IS ME");
			} else {
				$this->log("SOURCE IS NICK");
			}

		} else {
			// this is an event from the server
			$this->eventFrom = (self::FROM_SERVER);
			$this->sourceServer = $source;
			$this->log("SOURCE IS SERVER");
		}
	}

	/**
	 * This method parses the message type.
	 */
	private final function parseMsgType($msgType) {

		$msgType = trim($msgType);
		$this->eventMsgType = ($msgType);
		$this->log("TYPE $msgType");

		if (is_numeric($msgType))
		$this->eventType = (self::TYPE_NUMERIC);
		else if (0 === strpos($msgType, 'PRIVMSG'))
		$this->eventType = (self::TYPE_PRIVMSG);
		else if (0 === strpos($msgType, 'NOTICE'))
		$this->eventType = (self::TYPE_NOTICE);
		else if (0 === strpos($msgType, 'MODE'))
		$this->eventType = (self::TYPE_MODE);
		else if (0 === strpos($msgType, 'TOPIC'))
		$this->eventType = (self::TYPE_TOPIC);
		else if (0 === strpos($msgType, 'JOIN'))
		$this->eventType = (self::TYPE_JOIN);
		else if (0 === strpos($msgType, 'PART'))
		$this->eventType = (self::TYPE_PART);
		else if (0 === strpos($msgType, 'QUIT'))
		$this->eventType = (self::TYPE_QUIT);
		else if (0 === strpos($msgType, 'KICK'))
		$this->eventType = (self::TYPE_KICK);
		else if (0 === strpos($msgType, 'NICK'))
		$this->eventType = (self::TYPE_NICK);
		else if (0 === strpos($msgType, 'INVITE'))
		$this->eventType = (self::TYPE_INVITE);
	}

	/**
	 * This method parses the receiver.
	 */
	private final function parseTarget($target) {

		$target = trim($target);
		if (0 === strpos($target, ':')) {
			$target = substr($target, 1);
		}
		$this->log("TO TARGET $target");

		if (0 === strpos($target, '#')) {
			//FIXME there are also other channel-prefixes around...
			$this->eventOn = (self::ON_CHANNEL);
			$this->eventTo = (self::TO_CHANNEL);
			$this->targetChannel = $target;
		} else {
			if ($target == $this->botNick) {
				$this->isOnMe = true;
				$this->log("TARGET IS ME");
			}
			$this->eventOn = (self::ON_PRIVATE);
			$this->eventTo = (self::TO_NICK);
			$this->targetNick = $target;
		}
	}

	/**
	 * This method parses the message.
	 */
	private final function parseMessage($rawEvent) {
		/* The message itself starts either at position 2 from the
		 * raw-message if it is a server-message or it starts at
		 * position 3 when it is a user-message.
		 * For both cases, the message goes on to the last element
		 * of the raw-array.
		 */
		$message = '';
		$startAt = $this->isFromServer() ? 2 : 3;
		$size = count($rawEvent);
		for ($i = $startAt; $i < $size; $i++) {
			$message.= trim($rawEvent[$i]);
			$message.= ($i == $size - 1 ? '' : ' ');
		}
		// Cut the leading : if it exists.
		if (isset($message[0]) && ':' == $message[0]) {
			$message = substr($message, 1);
		}
		$this->eventMessage = trim($message);
	}

	/**
	 * This method parses the mode.
	 */
	private final function parseMode() {

		if ($this->isMode()) {

			$mode = explode(' ', $this->eventMessage);
			$this->inMode = $mode[0];

			if (isset($mode[1])) {
				// mode on nick(s)
				$this->modeTo = '';
				$modeCount = count($mode);
				for ($i = 1; $i < $modeCount; $i++) {
					if ($mode[$i] == $this->botNick)
					$this->isOnMe = true;

					$this->modeTo .= $mode[$i].' ';
				}
				$this->modeTo = trim($this->modeTo);
			}


			if ($this->isOnChannel()) {
				$mode = explode(' ', $this->eventMessage);
				$this->inMode = $mode[0];
				$this->modeTo = '';
				$modeCount = count($mode);
				for ($i = 1; $i < $modeCount; $i++) {
					if ($mode[$i] == $this->botNick)
					$this->isOnMe = true;

					$this->modeTo .= $mode[$i].' ';
				}

				if (empty($this->modeTo)) {
					$this->modeTo = $this->targetChannel;
					$this->eventTo = (self::TO_CHANNEL);
				} else {
					$this->eventTo = (self::TO_NICK);
				}

			} else if ($this->isFromServer()) {
				$mode = explode(':', $this->eventMessage);
				$this->modeTo = $mode[0];
				$this->inMode = $mode[1];
				$this->eventTo = (self::TO_NICK);
			}
			$this->log("MODE $this->inMode TARGET $this->modeTo");
		}
	}

	/**
	 * This method parses a kick.
	 */
	private final function parseKick() {

		if ($this->isKick()) {
			$this->eventTo = (self::TO_NICK);
			$kick = explode(':', $this->eventMessage);
			$this->targetNick   = trim($kick[0]);
			$this->eventMessage = trim($kick[1]);
		}
	}

	/**
	 * This method parses ctcp.
	 */
	private final function parseCtcp() {
		if ($this->isPrivmsg()
		&& false !== strpos($this->eventMessage, chr(01))) {

			$this->eventType = (self::TYPE_CTCP);
			$this->eventMessage = trim(str_replace(chr(01), '',
			$this->eventMessage));
			$exploded = explode(' ', $this->eventMessage);
			$ctcpType = array_shift($exploded);
			$this->ctcpType = strtoupper($ctcpType);
			$this->eventMessage = str_replace("$ctcpType ", '',
			$this->eventMessage);

			// Filter action (/me)
			if (0 === strpos($this->ctcpType, 'ACTION')) {
				$this->eventType = (self::TYPE_ACTION);
			}
			$this->log("CTCP [$this->ctcpType] $this->eventMessage");
		}
	}

	private final function isType($type) { return $type == $this->eventType; }
	private final function isFrom($from) { return $from == $this->eventFrom; }
	private final function isOn($on) { return $on == $this->eventOn; }
	private final function isTo($to) { return $to == $this->eventTo; }

	// Public getters and indicators
	// -------------------------------------------------------------------------
	
	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getMoepIrc() { return $this->moepIrc; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getSource() { return $this->eventSource; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getSourceNick() { return $this->sourceNick; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getSourceUser() { return $this->sourceUser; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getSourceHost() { return $this->sourceHost; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getServerName() { return $this->sourceServer; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getTarget() { return $this->eventTarget; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getTargetChannel() { return $this->targetChannel; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getTargetNick() { return $this->targetNick; }


	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getMsgType() { return $this->eventMsgType; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getCtcpType() { return $this->ctcpType; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getMessage() {
		if(!empty($this->currentCommand)) {
			return trim(substr($this->eventMessage, strlen($this->currentCommand)));
		} else {
			return $this->eventMessage;
		}
	}

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getMode() { return $this->inMode; }

	/**
	 * This method returns the
	 *
	 * @return string
	 */
	public final function getModeTarget() { return $this->modeTo; }




	/**
	 * This method indicates whether the given command was called.
	 * If the command is called, it will be stripped of the message in
	 * the current event.
	 *
	 * @param string $command The coammnd.
	 * @return boolean True if the given command was called, else false.
	 */
	public final function isCommand($command, $withouttrigger=false) {

		$trigger = ($withouttrigger)
		? '' : MoepUtil::getConfigValue('bot.trigger');

		$command = strtolower($trigger.$command);
		$message = strtolower($this->eventMessage);

		if ((0 === strpos($message, $command))) {
			//			// remove matching commands from message
			//			$this->eventMessage = substr($this->eventMessage, strlen($command));
			//			$this->eventMessage = trim($this->eventMessage);
			$this->currentCommand = $command;
			return true;
		} else {
			$this->currentCommand = null;
		}
		return false;
	}

	public final function isChannelCommand($command, $withouttrigger=false) {
		return $this->isPrivmsg()
		&& $this->isOnChannel()
		&& $this->isCommand($command, $withouttrigger);
	}

	public final function isPrivateCommand($command) {
		return $this->isPrivmsg()
		&& $this->isOnPrivate()
		&& $this->isCommand($command, true);
	}


	/**
	 * This method indicates whether this event is from the bot.
	 *
	 * @return boolean
	 */
	public final function isMe() { return $this->isMe; }

	/**
	 * This method indicates whether this event is undefined.
	 *
	 * @return boolean
	 */
	public final function isUndefined() { return $this->isType(self::UNDEFINED); }

	/**
	 * This method indicates whether this event is numeric.
	 *
	 * @return boolean
	 */
	public final function isNumeric() { return $this->isType(self::TYPE_NUMERIC); }

	/**
	 * This method indicates whether this event is an /me action.
	 *
	 * @return boolean
	 */
	public final function isAction() { return $this->isType(self::TYPE_ACTION); }

	/**
	 * This method indicates whether this event is CTCP.
	 *
	 * @return boolean
	 */
	public final function isCtcp() { return $this->isType(self::TYPE_CTCP); }

	/**
	 * This method indicates whether this event is an /invite
	 *
	 * @return boolean
	 */
	public final function isInvite() { return $this->isType(self::TYPE_INVITE); }
	/**
	 * This method indicates whether this event is a /join.
	 *
	 * @return boolean
	 */
	public final function isJoin() { return $this->isType(self::TYPE_JOIN); }

	/**
	 * This method indicates whether this event is a /kick
	 *
	 * @return boolean
	 */
	public final function isKick() { return $this->isType(self::TYPE_KICK); }

	/**
	 * This method indicates whether this event is a /mode.
	 *
	 * @return boolean
	 */
	public final function isMode() { return $this->isType(self::TYPE_MODE); }

	/**
	 * This method indicates whether this event is a /nick change.
	 *
	 * @return boolean
	 */
	public final function isNick() { return $this->isType(self::TYPE_NICK); }

	/**
	 * This method indicates whether this event is a NOTICE
	 *
	 * @return boolean
	 */
	public final function isNotice() { return $this->isType(self::TYPE_NOTICE); }

	/**
	 * This method indicates whether this event is a /part.
	 *
	 * @return boolean
	 */
	public final function isPart() { return $this->isType(self::TYPE_PART); }

	/**
	 * This method indicates whether this event is a PRIVMSG.
	 *
	 * @return boolean
	 */
	public final function isPrivmsg() { return $this->isType(self::TYPE_PRIVMSG); }

	/**
	 * This method indicates whether this event is a /quit.
	 *
	 * @return boolean
	 */
	public final function isQuit() { return $this->isType(self::TYPE_QUIT); }

	/**
	 * This method indicates whether this event is a /topic.
	 *
	 * @return boolean
	 */
	public final function isTopic() { return $this->isType(self::TYPE_TOPIC); }

	/**
	 * This method indicates whether this event comes from a user.
	 *
	 * @return boolean
	 */
	public final function isFromUser() { return $this->isFrom(self::FROM_USER); }

	/**
	 * This method indicates whether this event comes from a server.
	 *
	 * @return boolean
	 */
	public final function isFromServer() { return $this->isFrom(self::FROM_SERVER); }

	/**
	 * This method indicates whether this event is related to a nick.
	 *
	 * @return boolean
	 */
	public final function isToNick() { return $this->isTo(self::TO_NICK); }

	/**
	 * This method indicates whether this event
	 *
	 * @return boolean
	 */
	public final function isToChannel() { return $this->isTo(self::TO_CHANNEL); }

	/**
	 * This method indicates whether this event is meant for the bot.
	 *
	 * @return boolean
	 */
	public final function isOnMe() { return $this->isOnMe; }

	/**
	 * This method indicates whether this event occured in a private query.
	 *
	 * @return boolean
	 */
	public final function isOnPrivate() { return $this->isOn(self::ON_PRIVATE); }

	/**
	 * This method indicates whether this event occured on a channel.
	 *
	 * @return boolean
	 */
	public final function isOnChannel($channels=null) {

		#return $this->isOn(self::ON_CHANNEL);
		if (!$this->isOn(self::ON_CHANNEL)) {
			return false;
		}

		// check given channels
		$isOnChannels = true;
		if (is_array($channels)) {
			$isOnChannels = false;
			foreach ($channels as $c) {
				if ($c == $this->targetChannel) {
					$isOnChannels = true;
					break;
				}
			}
		}
		return $isOnChannels;
	}

}
?>
