#!/usr/bin/php
<?php
/**
 * This file is part of moepbot.
 * This is the bootstrap script for the bot.
 * 
 * @version $Id: moepbot.php,v 1.9 2009/03/15 15:45:09 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */

// this will only run in cli-mode
if ('cli' != php_sapi_name() && 'cgi' != php_sapi_name()) {
	die('Sorry, this script will only run in a cli/cgi-mode.');
}

// define environment
define('MOEPBOT_HOME',    dirname(__FILE__));
define('MOEPBOT_STARTER', __FILE__);
define('MOEPBOT_CLASSES', MOEPBOT_HOME.'/classes');
define('MOEPBOT_SCRIPTS', MOEPBOT_HOME.'/scripts');
define('MOEPBOT_DATA',    MOEPBOT_HOME.'/data');
define('CHAR_BOLD',       chr(2));
define('CHAR_COLOUR',     chr(3));

// several php settings

// set no timelimit to let the bot run in a endless loop
set_time_limit(0);

/**
 * This function is the internal error-handler.
 * @see http://php.net/set_error_handler
 */
function moepbot_errorhandler($errno, $errstr, $errfile, $errline) {
	echo "ERROR $errno\n\t$errstr\n\t$errfile:$errline\n";
}
// set the error-handler
set_error_handler('moepbot_errorhandler', E_ALL);

// set the local timezone
date_default_timezone_set('Europe/Berlin');

// set a memory limit
ini_set('memory_limit', '8M');
print 'memory_limit='.ini_get('memory_limit')."\n";

// load classes
include MOEPBOT_CLASSES."/MoepUtil.class.php";
include MOEPBOT_CLASSES."/MoepIrc.class.php";
include MOEPBOT_CLASSES."/MoepBot.class.php";
include MOEPBOT_CLASSES."/MoepEvent.class.php";
include MOEPBOT_CLASSES."/MoepScript.class.php";

// define basic functions

/** 
 * This is main().
 * @param $args Commandline arguments.
 */
function main($args) {
	$me = array_shift($args);
	while ($arg = array_shift($args)) {
		if ('--dump-db' == $arg || '-d' == $arg) {
			die(MoepUtil::magicArray(
			MoepUtil::loadArray(basename(array_shift($args)))));
		} else if ('--config-file' == $arg || '-c' == $arg) {
			$configFile = array_shift($args);
		} else if ('--fork' == $arg) {
			$fork = true;
		}
	}
	if (isset($configFile)) {
		if (is_file($configFile)) {
			if (isset($fork)) {
				MoepUtil::fork($configFile);
			} else {
				$bot = new MoepBot($configFile);
			}
		} else {
			die("No such file: $configFile\n");
		}
	} else {
		die("Usage: $me -c /path/to/config.file\n");
	}
}

// start the bot
main($_SERVER['argv']);
?>
