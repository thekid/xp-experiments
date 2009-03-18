<?php
/**
 * This file is part of moepbot.
 * @version $Id: sandbox.php,v 1.2 2009/03/15 14:10:20 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * $Id: sandbox.php,v 1.2 2009/03/15 14:10:20 schlind Exp $
 *
 * This script is a playground template for new scripts.
 *
 * @package     net.moep.irc.script
 * @version     $Revision: 1.2 $
 * @author      Sascha Schlindwein <phpbot@schlind.org>
 */


/*
 * A list of all available internal commands:
 * 
 * self::isInit()
 * self::isHeartBeat()
 * self::getSource()
 * self::getTarget()
 * self::isNumeric()
 * self::isAction()
 * self::isCtcp()
 * self::isInvite()
 * self::isJoin()
 * self::isKick()
 * self::isMode()
 * self::isNick()
 * self::isNotice()
 * self::isPart()
 * self::isPrivmsg()
 * self::isQuit()
 * self::isTopic()
 * self::isFromUser()
 * self::isFromServer()
 * self::isOnPrivate()
 * self::isOnChannel()
 * self::isToNick()
 * self::isToChannel()
 * self::getSourceNick()
 * self::getSourceUser()
 * self::getSourceHost()
 * self::getServerName()
 * self::getTargetChannel()
 * self::getTargetNick()
 * self::getMsgType()
 * self::getCtcpType()
 * self::isMe()
 * self::getMessage()
 * self::getMode()
 * self::getModeTarget()
 * self::isOnMe()
 * self::isCommand($command, $withouttrigger=false)
 * self::isHelpTriggered($command=null)
 * self::getEnv($name, $default=null)
 * self::setEnv($name, $value)
 * self::getBrain($name, $default=null)
 * self::setBrain($name, $value)
 * self::getConfigValue($name)
 * self::getConfigList($name)
 * self::bold($text)
 * self::colour($text, $fg, $bg=null)
 * self::sendMessage($to, $message)
 * self::sendNotice($to, $message)
 * self::sendCTCP($to, $message)
 * self::sendCTCPReply($to, $message)
 * self::sendAction($to, $action)
 * self::setTopic($channel, $topic)
 * self::joinChannel($channel)
 * self::partChannel($channel)
 * self::setAway($reason=null)
 * self::sendWho($channel)
 * self::getMyNick()
 * self::getServerSupport($name,$default=null)
 * self::changeNick($newNick)
 * self::kick($nick, $channel, $reason)
 * self::setChannelMode($channel, $mode, $nick=null)
 *
 */

if (self::isInit()) {
	// this block is executed when the script is (re)loaded
	self::log('$Id: sandbox.php,v 1.2 2009/03/15 14:10:20 schlind Exp $');
} else if (self::isHeartBeat()) {
	// this block is executed on every heartbeat
	self::log("[sandbox] isHeartBeat()");
} else {
	// this block is executed on any other event

	if (self::isOnChannel() && self::isPrivmsg() 
	&& self::isCommand('sandbox')) {
		
	}
}
?>
