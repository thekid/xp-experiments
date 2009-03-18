<?php
/**
 * This file is part of moepbot.
 * @version $Id: calc.php,v 1.14 2009/03/15 16:08:29 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * $Id: calc.php,v 1.14 2009/03/15 16:08:29 schlind Exp $
 *
 * This script is a from mind remake of some features experienced by calc.tcl
 * for eggdrop bots.
 *
 * So what exactly is a calc? Calc is an abbreviation of the word
 * calculation. That means that this script will calculate simple
 * mathematical expressions, but this is a feature not really to mention.
 *
 *   <you> calc 2 + 3
 *   <bot> 2 + 3 = 5
 *
 * The heavy used feature is storage and retrieval of previously
 * defined (mostly not so mathematical) definitions.
 *
 * + add a new definition
 *   <you> calc foo = bar
 *   <bot> thanks
 *
 * + request a definition
 *   <you> calc foo
 *   <bot> foo = bar [you]
 *
 * + request a random definition (the killerfeature)
 *   <you> calc
 *   <bot> bar = baz [someone]
 *
 * + search for a definition
 *   <you> match foo
 *   <bot> found 2 entries:
 *   <bot> foo = bar
 *   <bot> bar = foo
 * 
 *
 * @package     org.schlind.moepbot.scripts
 * @version     1.0 $Revision: 1.14 $
 * @author      Sascha Schlindwein <moepbot@schlind.org>
 */

// some config
$calc_current_file = self::getConfigValue('bot.name').'-calc-current.array';
$calc_history_file = self::getConfigValue('bot.name').'-calc-history.array';
$calc_history_maxlines = 3;

if (self::isInit()) {
	// init-phase
	self::log('[calc] $Id: calc.php,v 1.14 2009/03/15 16:08:29 schlind Exp $');
	self::log('[calc] channels: ALL + QUERY');
	self::log('[calc] commands: calc match');
}

else if (self::isHelpTriggered()) {
	// global help
	self::sendMessage(self::getSourceNick(),
	'[calc-script] fuer weitere Hilfe gib "?calc" ein');
}

else if (self::isHelpTriggered('?calc') || self::isHelpTriggered('?match')) {

	// help message
	self::sendMessage(self::getSourceNick(),
	self::getSourceNick().', CALC funktioniert im Kanal und im Query:');
	self::sendMessage(self::getSourceNick(),
	'Die 4 Grundrechenarten +-*/ benutzen, z.B. mit "calc (2 + 3) * 2 + 1"'
	.' ODER die Definition zu einem Ausdruck abfragen mit "calc ausdruck"'
	.' ODER eine Zufallsdefinition abfragen mit "calc"'
	.' ODER eine neue Definition eintragen mit "calc ausdruck = Deine neue Definition"'
	.' ODER eine Definition entfernen mit "calc ausdruck ="');
	self::sendMessage(self::getSourceNick(),
	'Mit "match ausdruck" kannst Du die calc-Datenbank nach bestimmten Ausdruecken durchsuchen.');
}

// the calc command works in channels and private queries
else if (self::isPrivmsg() && self::isCommand('calc', true)) {
	
	// this block is executed by a message in a channel
	// and when the message either begins with '<bot.trigger>calc' or 'calc'

	// gather requested calc and some metainfo
	$calc = self::getMessage();
	$calc_nick = self::getSourceNick();
	$calc_source = self::getSource();
	$calc_respond_to = self::isOnChannel()
	? self::getTargetChannel() : $calc_nick;

	// load all available calcs
	$calc_db =& MoepUtil::getArray($calc_current_file);

	// command parsing is done in 3 steps:
	// 1st check for empty calcs which results in an random answer
	// 2nd check for '=' which indicates a new incoming definition
	// 3rd lookup requested calc
	// 4th check for expression to calculate

	// 1
	if (empty($calc)) {
		// empty calc means random calc

		if (0 < count($calc_db)) {
			// gather random calc
			$calc = array_rand($calc_db);
			if (isset($calc_db[$calc]['text'])) {
				// have a random calc
				$text = isset($calc_db[$calc]['text'])
				? $calc_db[$calc]['text'] : '?';
				$real = isset($calc_db[$calc]['real'])
				? $calc_db[$calc]['real'] : '?';
				#$date = isset($calc_db[$calc]['time'])
				#? date('Y/m/d/H/i', $calc_db[$calc]['time']):'?';
				#$nick = isset($calc_db[$calc]['nick'])
				#? $calc_db[$calc]['nick'] : '?';
				self::sendMessage($calc_respond_to, "$real = $text"); #[$date/$nick]
			} else {
				// random calc gone wrong
				self::sendAction($calc_respond_to, 'calct grad nicht..');
			}
		} else {
			// have no calcs
			self::sendAction($calc_respond_to, 'hat kein calc..');
		}

	}

	// 2
	else if (stristr($calc, '=')) {
		// add new or update calc

		// parse <expression>=<definition>
		$newcalc  = explode('=', $calc); // [0]->expression, [1]->definition
		$calc     = trim(array_shift($newcalc)); // before the 1st '='
		$real     = $calc; //copy real calc before strtolower
		$calc     = strtolower($calc);
		$newcalc  = implode('=', $newcalc); // behind the 1st '='
		$text     = trim($newcalc);

		// check if this calc already has an entry
		if (  isset($calc_db[$calc])
		&& is_array($calc_db[$calc])) {
			// having an entry, creating history
			$calc_history =& MoepUtil::getArray($calc_history_file);
			$calc_history[$calc][] = $calc_db[$calc];
		}

		if (empty($text)) {
			// empty text means to forget about the current entry
			unset($calc_db[$calc]);
			self::sendAction($calc_respond_to, "vergisst '$calc'..");
		} else {
			// text is set, create an entry
			$calc_db[$calc]['text'] = $text;
			$calc_db[$calc]['real'] = $real;
			$calc_db[$calc]['chan'] = $calc_respond_to;
			$calc_db[$calc]['nick'] = $calc_nick;
			$calc_db[$calc]['mask'] = $calc_source;
			$calc_db[$calc]['time'] = time();
			$calc_count = count($calc_db);
			self::sendAction($calc_respond_to, "merkt sich '$calc'..");
		}

	}

	// 3
	else if (isset($calc_db[$calc])
	&&      is_array($calc_db[$calc])) {
		// requested calc exists

		// gather text, time, nick and send response
		$text = isset($calc_db[$calc]['text'])
		? $calc_db[$calc]['text'] : '?';
		$real = isset($calc_db[$calc]['real'])
		? $calc_db[$calc]['real'] : '?';
		#$date = isset($calc_db[$calc]['time'])
		#? date('Y/m/d/H/i', $calc_db[$calc]['time']):'?';
		#$nick = isset($calc_db[$calc]['nick'])
		#? $calc_db[$calc]['nick'] : '?';
		self::sendMessage($calc_respond_to, "$real = $text");#[$date/$nick]

		// some history
		$calc_history =& MoepUtil::getArray($calc_history_file);
		if (isset($calc_history[$calc]) && is_array($calc_history[$calc])) {
			$count = 0;
			foreach ($calc_history[$calc] as $history) {
				$text = isset($history['text']) ? $history['text'] : '?';
				$real = isset($history['real']) ? $history['real'] : '?';
				#$date = isset($history['time']) ? date('Y/m/d/H/i', $history['time']):'?';
				#$nick = isset($history['nick']) ? $history['nick'] : '?';
				self::sendMessage($calc_respond_to, "$real ~ $text"); #[$date/$nick]
				if ($calc_history_maxlines <= ++$count) break;
			}
		}

	}

	// 4
	else {
		// this must be somecalc else, try to find a 'mathematical' expression
		// valid parts are numbers from 0 to 9, and each char of .()+-*/ and blanks

		if (preg_match('/^[0-9\.\(\)\+\-\*\/\ ]+$/u', $calc)) {
			// calculate the expression, using eval might be offensive but works
			$calc_expressionresult =
			'ein Ausdruck den man nicht berechnen kann? o_O';
			eval ("\$calc_expressionresult = $calc;");
			self::sendMessage($calc_respond_to, "$calc = $calc_expressionresult");
		} else {
			// cant do anything with this calc
			$response = array(
			'hat keine Ahnung von %%%',
			'kann mit %%% nix anfangen',
			'kann zu %%% nix sagen',
			'weiss nix von %%%'
			);
			self::sendAction($calc_respond_to,
			str_replace('%%%',$calc, $response[array_rand($response)]));
		}
	}

	
	unset($calc_db, $calc, $calc_history,
	$calc_respond_to, $calc_nick, $calc_source, $calc_count,
	$calc_expressionresult, $response);

}


// the match command works in channels and private queries
else if (self::isPrivmsg() && (self::isCommand('match', true))) {
	$match = strtolower(self::getMessage());
	$match_nick = self::getSourceNick();
	$match_source = self::getSource();
	$match_respond_to = self::isOnChannel()
	? self::getTargetChannel() : $match_nick;

	if (!empty($match) /*&& '*' != $match*/ && 3 > strlen($match)) {
		self::sendMessage($match_respond_to,
		"Der Suchbegriff muss mindestens 3 Buchstaben enthalten");
	}
	else if (!empty($match)) {

		self::sendMessage($match_respond_to, "Suche beginnt...");

		$calc_db =& MoepUtil::getArray($calc_current_file);
		self::log("[calc] $match_respond_to searching for '$match' ($match_nick)");
		$match_results = array();
		foreach ($calc_db as $calc => $data) {
			$real = isset($data['real']) ? $data['real'] : null;
			$text = isset($data['text']) ? $data['text'] : null;
				#$date = isset($data['time']) ? date('Y/m/d/H/i', $data['time']):'?';
				#$nick = isset($data['nick']) ? $data['nick'] : '?';
			if (stristr($calc,$match) || stristr($text,$match)) {
				#self::log("[calc] match $calc: ".print_r($data, true));
				$match_results[] = "$real = $text"; #[$date/$nick]
			}
		}
		self::sendMessage($match_respond_to,
		count($match_results).' Treffer fuer '.MoepUtil::bold($match));
		foreach ($match_results as $result){
			self::sendMessage($match_respond_to, $result);
		}
	}

	unset($calc_db, $match, $match_nick, $match_respond_to, $match_results, 
	$match_source, $matches);
}
?>
