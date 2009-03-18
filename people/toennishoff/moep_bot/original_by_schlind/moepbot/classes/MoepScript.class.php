<?php
/**
 * This file is part of moepbot.
 * @version $Id: MoepScript.class.php,v 1.9 2009/03/15 15:45:09 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * This class is an interface for scripts that can be (re)-loaded while
 * MoepBot is running and online.
 *
 * @package net.moep.irc.moepbot
 * @version 1.0 ($Revision: 1.9 $)
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 */
final class MoepScript {

	/* This member contains all the script file names. */
	private static $scriptFiles = array();
	/* This member contains all the script code. */
	private static $scriptCodes = array();
	/* This member is the current processed event. */
	private static $event; // has no initial value

	/**
	 * This is the default constructor.
	 *
	 * @param MoepEvent $moepEvent
	 */
	public function MoepScript(MoepEvent $moepEvent) {
		if ($moepEvent instanceof MoepEvent) {
			self::$event = $moepEvent;
		}
		foreach (self::$scriptCodes as $scriptFile => $scriptCode) {
			#self::log("Executing $scriptFile");
			eval("?>$scriptCode<?");
		}
	}

	/**
	 * This method writes a message to the log.
	 *
	 * @param string $message
	 */
	private final static function log($message) {
		MoepUtil::log("MoepScript $message");
	}

	/**
	 * This method adds a script file.
	 *
	 * @param string $fileName
	 */
	private final static function addScript($fileName) {
		if (is_string($fileName) && 0 < strlen($fileName)) {
			$fileName = MOEPBOT_SCRIPTS."/$fileName";
			if (is_file($fileName)) {
				#self::log("Adding script $fileName");
				self::$scriptFiles[$fileName] = $fileName;
			} else {
				self::log("Script $fileName not found");
			}
		}
	}

	/**
	 * This method removes a script file.
	 *
	 * @param string $file
	 */
	public final static function removeScript($file) {
		unset(self::$scriptFiles[MOEPBOT_SCRIPTS."/$file"]);
		self::loadScripts();
	}

	/**
	 * This method sets all script files.
	 *
	 * @param array $scripts
	 */
	public final static function setScripts($scripts) {
		self::$scriptFiles = array();
		foreach ($scripts as $script) {
			self::addScript($script);
		}
	}

	/**
	 * This method loads all scripts into the internal code cache.
	 */
	public final static function loadScripts() {
		self::$event = null;
		self::$scriptCodes = array();
		$count = 0;
		$scripts = self::$scriptFiles;
		foreach ($scripts as $file) {
			if (is_file($file)) {
				$code = file_get_contents($file);
				$code = trim($code);
				eval("?>$code<?"); // "load" scriptcode by executing it once here..
				self::$scriptCodes[$file] = $code; // store code..
				$count++;
			} else {
				self::log("Not found: $file");
			}
		}
		self::log("Loaded $count scripts");
	}


	// MoepUtil delegates
	// -------------------------------------------------------------------------

	private final static function getEnv($name, $default=null) {
		return MoepUtil::getEnv($name, $default);
	}
	private final static function setEnv($name, $value) {
		MoepUtil::setEnv($name, $value);
	}
	private final static function getBrain($name, $default=null) {
		return MoepUtil::getBrain($name, $default);
	}
	private final static function setBrain($name, $value) {
		MoepUtil::setBrain($name, $value);
	}
	private final static function getConfigValue($name) {
		return MoepUtil::getConfigValue($name);
	}
	private final static function getConfigList($name) {
		return MoepUtil::getConfigList($name);
	}
	private final static function bold($text) {
		return MoepUtil::bold($text);
	}
	private final static function colour($text, $fg, $bg=null) {
		return MoepUtil::colour($text, $fg, $bg);
	}

	// -------------------------------------------------------------------------
	// MoepEvent delegates
	// -------------------------------------------------------------------------
	private final static function isInit() { return empty(self::$event); }
	private final static function isHeartBeat() {
		return isset(self::$event) && self::$event->isUndefined();
	}
	private final static function getSource() {
		return isset(self::$event)
		&& self::$event->getSource();
	}
	private final static function getTarget() {
		return isset(self::$event)
		&& self::$event->getTarget();
	}
	private final static function isNumeric() {
		return isset(self::$event)
		&& self::$event->isNumeric();
	}
	private final static function isAction() {
		return isset(self::$event)
		&& self::$event->isAction();
	}
	private final static function isCtcp() {
		return isset(self::$event)
		&& self::$event->isCtcp();
	}
	private final static function isInvite() {
		return isset(self::$event)
		&& self::$event->isInvite();
	}
	private final static function isJoin() {
		return isset(self::$event)
		&& self::$event->isJoin();
	}
	private final static function isKick() {
		return isset(self::$event)
		&& self::$event->isKick();
	}
	private final static function isMode() {
		return isset(self::$event)
		&& self::$event->isMode();
	}
	private final static function isNick() {
		return isset(self::$event)
		&& self::$event->isNick();
	}
	private final static function isNotice() {
		return isset(self::$event)
		&& self::$event->isNotice();
	}
	private final static function isPart() {
		return isset(self::$event)
		&& self::$event->isPart();
	}
	private final static function isPrivmsg() {
		return isset(self::$event)
		&& self::$event->isPrivmsg();
	}
	private final static function isQuit() {
		return isset(self::$event)
		&& self::$event->isQuit();
	}
	private final static function isTopic() {
		return isset(self::$event)
		&& self::$event->isTopic();
	}
	private final static function isFromUser() {
		return isset(self::$event)
		&& self::$event->isFromUser();
	}
	private final static function isFromServer() {
		return isset(self::$event)
		&& self::$event->isFromServer();
	}
	private final static function isOnPrivate() {
		return isset(self::$event)
		&& self::$event->isOnPrivate();
	}
	private final static function isOnChannel($channels=null) {
		return isset(self::$event)
		&& self::$event->isOnChannel($channels);
	}
	private final static function isToNick() {
		return isset(self::$event)
		&& self::$event->isToNick();
	}
	private final static function isToChannel() {
		return isset(self::$event)
		&& self::$event->isToChannel();
	}
	private final static function getSourceNick() {
		return isset(self::$event)
		? self::$event->getSourceNick() : null;
	}
	private final static function getSourceUser() {
		return isset(self::$event)
		? self::$event->getSourceUser() : null;
	}
	private final static function getSourceHost() {
		return isset(self::$event)
		? self::$event->getSourceHost() : null;
	}
	private final static function getServerName() {
		return isset(self::$event)
		? self::$event->getServerName() : null;
	}
	private final static function getTargetChannel() {
		return isset(self::$event)
		? self::$event->getTargetChannel() : null;
	}
	private final static function getTargetNick() {
		return isset(self::$event)
		? self::$event->getTargetNick() : null;
	}
	private final static function getMsgType() {
		return isset(self::$event)
		? self::$event->getMsgType() : null;
	}
	private final static function getCtcpType() {
		return isset(self::$event)
		? self::$event->getCtcpType() : null;
	}
	private final static function isMe() {
		return isset(self::$event)
		? self::$event->isMe() : null;
	}
	private final static function getMessage() {
		return isset(self::$event)
		? self::$event->getMessage() : null;
	}
	private final static function getMode() {
		return isset(self::$event)
		? self::$event->getMode() : null;
	}
	private final static function getModeTarget() {
		return isset(self::$event)
		? self::$event->getModeTarget() : null;
	}
	private final static function isOnMe() {
		return isset(self::$event)
		&& self::$event->isOnMe();
	}
	private final static function isCommand($command, $withouttrigger=false) {
		return isset(self::$event)
		&& self::$event->isCommand($command, $withouttrigger);
	}
	private final static function isChannelCommand($command, $withouttrigger=false) {
		return isset(self::$event)
		&& self::$event->isChannelCommand($command, $withouttrigger);
	}
	private final static function isPrivateCommand($command) {
		return isset(self::$event)
		&& self::$event->isPrivateCommand($command);
	}
	private final static function isHelpTriggered($command=null) {
		if ($command) {
			return self::isPrivmsg()
			#&& self::isOnPrivate()
			&& self::isCommand($command, true);
		} else {
			return self::isPrivmsg() &&
			( self::isOnChannel() && self::isCommand('help')
			|| self::isOnPrivate() && self::isCommand('help', true));
		}
	}

	// MoepEvent -> MoepIrc delegates
	// -------------------------------------------------------------------------
	private final static function sendMessage($to, $message) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->sendMessage($to, $message);
	}
	private final static function sendNotice($to, $message) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->sendNotice($to, $message);
	}
	private final static function sendCTCP($to, $message) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->sendCTCP($to, $message);
	}
	private final static function sendCTCPReply($to, $message) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->sendCTCPReply($to, $message);
	}
	private final static function sendAction($to, $action) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->sendAction($to, $action);
	}
	private final static function setTopic($channel, $topic) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->setTopic($channel, $topic);
	}
	private final static function joinChannel($channel) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->joinChannel($channel);
	}
	private final static function partChannel($channel) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->partChannel($channel);
	}
	private final static function setAway($reason=null) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->setAway($reason);
	}
	private final static function sendWho($channel) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->sendWho($channel);
	}
	private final static function getMyNick() {
		return isset(self::$event)
		? self::$event->getMoepIrc()->getMyNick() : null;
	}
	private final static function getServerSupport($name,$default=null) {
		return isset(self::$event)
		? self::$event->getMoepIrc()->getServerSupport($name,$default) : null;
	}
	private final static function changeNick($newNick) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->changeNick($newNick);
	}
	private final static function kick($nick, $channel, $reason) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->kick($nick, $channel, $reason);
	}
	private final static function setChannelMode($channel, $mode, $nick=null) {
		isset(self::$event)
		&& self::$event->getMoepIrc()->setChannelMode($channel, $mode, $nick);
	}

}
?>
