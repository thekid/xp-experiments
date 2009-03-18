<?php
/**
 * This file is part of moepbot.
 * @version $Id: MoepUtil.class.php,v 1.8 2009/03/15 15:45:09 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 *
 * @package net.moep.irc
 * @version 1.0 ($Revision: 1.8 $)
 * @author Sascha 'lupo' Schlindwein <schlind@moep.net>
 */
final class MoepUtil {

	private static $CONFIG_FILE = null;
	private static $CONFIG_HASH = array();

	/**/
	static $logWithTimeStamp = true;
	/**/
	private static $arrays = array();
	/**/
	private static $arrayHashes = array();

	/* This member provides static environment/runtime settings. */
	private static /*array*/   $env = array();

	/**
	 * This is the default constructor.
	 * @return MoepBot
	 */
	private function MoepUtil() {
		// NOP
	}


	public static function loadConfig($configFile) {
		if (is_file($configFile) && is_readable($configFile)) {
			self::$CONFIG_FILE = $configFile;
			self::$CONFIG_HASH = array();
			foreach ($lines = file($configFile) as $line) {
				$line = trim($line);
				if (0 === strpos($line, '//')) continue; // skip comments
				// remember: '#' shouldn't be a comment because '#channel'
				$pair  = explode("=", $line);
				$name  = isset($pair[0]) ? trim($pair[0]) : null;
				$value = isset($pair[1]) ? trim($pair[1]) : null;
				if ('false' == strtolower($value)) $value = 0;
				else if ('true' == strtolower($value)) $value = 1;
				else if ('null' == strtolower($value)) $value = null;
				if (!empty($name)) {#print "$name=$value\n";
					self::$CONFIG_HASH[$name] = $value;
				}
			}
		} else {
			throw new Exception("File not found: $configFile");
		}
			
	}

	private function saveConfig() {
		/* TODO Implement a intelligent save-method, don't write back to the
		 * original file given on construction, use rather "<filename>.runtime"
		 * and respect this file also on load(). Load the original file first
		 * and then override values from the .runtime file, as an idea.. do
		 * what you want.. ;)
		 */
	}
	public static function getConfigFile() {
		return self::$CONFIG_FILE;
	}

	/**
	 * This method implements the hook to handle config values as required by
	 * class MoepIrc.
	 *
	 * This method returns the config value relating to the given name.
	 *
	 * @param string $name The name of the config value.
	 * @return string The config value.
	 */
	public static function getConfigValue($name) {
		return isset(self::$CONFIG_HASH[$name]) ? self::$CONFIG_HASH[$name] : null;
	}

	/**
	 * This method implements the hook to handle config values as required by
	 * class MoepIrc.
	 *
	 * This method returns the config values relating to the given name
	 * prefix.
	 *
	 * @param string $prefix The name prefix of the config values.
	 * @return array The config values.
	 */
	public static function getConfigList($listName) {
		//		$values = array();
		//		foreach (self::$CONFIG_HASH as $name => $value) {
		//			if (0===strpos("$name.", $listName)) {
		//				$values[$name] = $value;
		//			}
		//		}
		//		return $values;
		//	}
		//	public static function getConfigList2($listName) {
		$list = self::getConfigValue($listName);
		$values = array();
		if (!empty($list)) {
			$value_array = explode(',',$list);
			foreach ($value_array as $value) {
				$values[] = trim($value);
			}
		}
		return $values;
	}


	/**
	 * @param string $message
	 */
	public static function log($message) {

		static $today = null;

		$message = trim($message);
		$ignores = explode(',',self::getConfigValue('log.ignore'));
		if (is_array($ignores) && 0 < count($ignores)) {
			foreach ($ignores as $ignore) {
				#print "-- [$ignore] in [$message]?\n";
				$ignore = trim($ignore);
				if (empty($ignore)) continue;
				if (0 === strpos($message, $ignore)) {
					return;
				}
			}
		}
		if (1||           self::getConfigValue('log.timestamp')) {
//			if (empty($today)) {
//				$today = date('dmy');
//				print '---8<---| '.date('d.m.y')."\n";
//			}
			if (date('dmy') != $today) {
				// daychange
				$today = date('dmy');
				print '---8<--- '.date('d.m.Y')."\n";
			}
			#			print date('d.m.y-H:i:s')."| $message\n";
			print date('H:i:s')." $message\n";
		} else {
			print "$message\n";
		}
	}

	/**
	 * @param unknown_type $message
	 */
	private static function logUtil($message) {
		self::log("MoepUtil $message");
	}


	/**
	 * This method saves an array to a file.
	 *
	 * @param array $array
	 * @param string $file
	 */
	public static function saveArray($array, $file) {
		$file = MOEPBOT_DATA."/$file";
		if (is_dir($file))
		throw new Exception("You want to open dir $file as file?");
		$data = serialize($array);
		$fp = fopen($file, 'w');
		if (is_resource($fp)) {
			fputs($fp, $data);
			fclose($fp);
			$fsize = round((filesize($file) / 1024), 2).'kB';

			$file = basename($file);
			self::logUtil("Wrote $file ($fsize)");
		}
	}

	/**
	 * This method loads an array from a file.
	 *
	 * @param string $name
	 * @return array
	 */
	public static function loadArray($name) {

		$file = MOEPBOT_DATA."/$name";

		if (is_dir($file))
		throw new Exception("You want to open dir $file as file?");

		$array = null;
		if (is_file($file) && is_readable($file)) {
			$fsize = round((filesize($file) / 1024), 2).'kB';
			self::logUtil("Loading $file ($fsize)");
			$data  = file_get_contents($file);
			$array = unserialize($data);
		} else {
			self::log("Creating $file");
			touch($file);
		}
		if (!is_array($array)) $array = array();

		$hash = sha1(self::magicArray($array));
		self::$arrayHashes[$name] = $hash;
		#self::logUtil("$name=$hash");

		return $array;
	}

	/**
	 * This method provides the reference on an persistent array.
	 *
	 * @param string $name
	 * @return array
	 */
	public static function &getArray($name) {
		if (isset(self::$arrays[$name])) {
			return self::$arrays[$name];
		} else {
			self::$arrays[$name] = self::loadArray($name);
		}
		return self::$arrays[$name];
	}

	/**
	 * This method saves all persistent arrays to their files.
	 */
	public static function saveArrays() {
		#self::logUtil("Saving arrays...");

		$arrays = self::$arrays;
		foreach ($arrays as $name => $array) {
			$hash = sha1(self::magicArray($array));
			if (!isset(self::$arrayHashes[$name])
			|| self::$arrayHashes[$name] != $hash) {
				#self::logUtil("Saving $name");
				self::saveArray($array, $name);
				self::$arrayHashes[$name] = $hash;
			} else {
				#self::logUtil("No need to write $name...");
			}
		}
		self::$arrayHashes = array();
		self::$arrays = array();
	}

	/**
	 * Enter description here...
	 *
	 */
	public static function dumpArrays() {
		print ("========\n");
		print MoepUtil::magicArray(self::$arrays);
		print MoepUtil::magicArray(self::$env);
		print ("========\n");
	}


	////  ////  ////  ////  ////  ////  ////  ////  ////  ////  ////  ////  ////

	/**
	 * Enter description here...
	 *
	 * @param unknown_type $maskA
	 * @param unknown_type $maskB
	 * @return unknown
	 */
	public static function masksMatch($maskA, $maskB) {

		static $cache = array();

		if (empty($maskA) || empty($maskB)) return;

		if (isset($cache[$maskA][$maskB])) {
			#self::log("(cached) $maskA <-> $maskB");
			return $cache[$maskA][$maskB];
		}

		$cache[$maskA][$maskB] = false;

		#self::logUtil("Matching? $maskA <-> $maskB");

		$nickMatch = false;
		$userMatch = false;
		$hostMatch = false;

		preg_match('/(.*)!(.*)@(.*)/', $maskA, $maskAx);
		array_shift($maskAx);
		$nickA = array_shift($maskAx);
		$userA = array_shift($maskAx);
		$hostA = array_shift($maskAx);

		preg_match('/(.*)!(.*)@(.*)/', $maskB, $maskBx);
		array_shift($maskBx);
		$nickB = array_shift($maskBx);
		$userB = array_shift($maskBx);
		$hostB = array_shift($maskBx);

		if ('*' == $nickA || '*' == $nickB || $nickA == $nickB) {
			$nickMatch = true;
		}

		if ('*' == $userA || '*' == $userB || $userA == $userB) {
			$userMatch = true;
		}

		if ('*' == $hostA || '*' == $hostB || $hostA == $hostB) {
			$hostMatch = true;
		}

		if ($nickMatch && $userMatch && $hostMatch) {
			#self::log("Matching! $maskA <-> $maskB");
			$cache[$maskA][$maskB] = true;
			return true;
		}
	}

	/**
	 * This method transforms the given object (array) into an human readable
	 * form.
	 *
	 * @param mixed $array The array/object.
	 * @param string $path The rootpath.
	 */
	public static function magicArray($array, $path='') {
		$string = '';
		if (is_array($array)) {
			ksort($array);
			if (!empty($path)) $path = "$path/";
			foreach ($array as $key=>$val) $string.=self::magicArray($val, "$path$key");
		} else if (is_object($array)) {
			$string.= self::magicArray(serialize($array), $path);
		} else {
			$array = $array ? "=> $array" : '';
			$string.= ("$path $array\n");
		}
		return $string;
	}

	/**
	 * This method display a small rotor on the console.
	 *
	 * @param int $ms
	 * @param int $cycles
	 */
	public static function rotor($ms=100, $cycles=1) {
		$usleep = 1000 * $ms;
		while ($cycles-->0) {
			foreach ($rotor = explode(' ', "- \\ | /") as $rotation) {
				print $rotation; flush(); usleep($usleep); print "\r";
			}
		}
	}

	public static function rotor2($ms=100, $cycles=1) {

		$start = 0;
		$width = 16;

		$usleep = 1000 * $ms;


		while ($cycles-->0) {
			$step=0;
			while ($step<=$width) {
				$step++;
				print str_repeat(' ',$step).'#';
				flush(); usleep($usleep);
				print "\r";
			}
			while (++$step<=$width) {
				print str_repeat(' ',$step).'#';
				flush(); usleep($usleep);
				print "\r";
			}
			while (--$step>=0) {
				print '#'.str_repeat(' ',$step);
				flush(); usleep($usleep);
				print "\r";
			}
		}
	}


	/**
	 * Enter description here...
	 *
	 * @param unknown_type $then
	 * @return unknown
	 */
	public static function ago($then){
		$ago   = '';
		$now   = time();
		$diff  = $now - $then;
		$days  = floor($diff / 86400);
		$diff  = $diff - ($days * 86400);
		$hours = floor($diff / 3600);
		$diff  = $diff - ($hours * 3600);
		$mins  = floor($diff / 60);
		$diff  = $diff - ($mins * 60);
		$secs  = $diff;

		if (0<$days) {
			if (1==$days) { $ago.= $days."d, "; }
			else { $ago.= $days."d, "; }
		}
		if (0<$hours){
			if (1==$hours) { $ago.= $hours."h, "; }
			else { $ago.= $hours."h, "; }
		}
		if (0<$mins) {
			if (1==$mins) { $ago.= $mins."m, "; }
			else { $ago.= $mins."m, "; }
		}
		if (0<$secs) {
			if (1==$secs) { $ago.= $secs."s"; }
			else { $ago.= $secs."s"; }
		}
		return $ago;
	}

	public static function fork($configFile) {
		exec(MOEPBOT_STARTER.' --config-file '.$configFile
		.' >> '.MOEPBOT_HOME.'/moepbot.log &');
		die();
	}

	public static function getFileAsArray($pathToFile) {
		if (is_file($pathToFile) && is_readable($pathToFile)) {
			return file($pathToFile);
		} else {
			throw new Exception("File not found: $pathToFile");
		}
	}


	public static function bold($string) { return CHAR_BOLD.$string.CHAR_BOLD; }
	public static function colour($string, $fg, $bg=null) {
		$colour = empty($bg) ? "$fg" :"$fg,$bg";
		return CHAR_COLOUR.$colour.$string.CHAR_COLOUR;
	}

	private static $fileAppenders = array();
	public static function appendToFile($fileName, $string) {

		if (!isset(self::$fileAppenders[$fileName])
		|| !is_resource(self::$fileAppenders[$fileName])) {
			self::$fileAppenders[$fileName] = fopen($fileName, 'a');
		}
		fwrite(self::$fileAppenders[$fileName], $string);
		fclose(self::$fileAppenders[$fileName]);
	}

	public static function appendLineToFile($fileName, $line) {
		self::appendToFile($fileName, "$line\n");
	}
	public static function getRandomLineFromFile($fileName) {
		$lines = file($fileName);
		return $lines[rand(0, count($file) - 1)];
	}

	public static function searchLineInFile($fileName, $search) {
		$lines = file($fileName);
		$foundLines = array();
		foreach ($lines as $line) {
			if (stristr($line,$search)) {
				$foundLines[] = $line;
			}
		}
		return $foundLines;
	}




	/**
	 * This method returns a static environment variable.
	 *
	 * @param unknown_type $name
	 * @param unknown_type $default
	 * @return unknown
	 */
	public final static function getEnv($name, $default=null) {
		return isset(self::$env[$name]) ? self::$env[$name] : $default;
	}

	/**
	 * This method sets a static environment variable.
	 *
	 * @param unknown_type $name
	 * @param unknown_type $value
	 */
	public final static function setEnv($name, $value) {
		if ($value){
			self::$env[$name] = $value;
		} else {
			unset(self::$env[$name]);
		}
	}

	public final static function setBrain($name, $value=null) {
		$brain =& self::getArray(self::getConfigValue('bot.file'));
		if ($value){
			$brain[$name] = $value;
		} else {
			unset($brain[$name]);
		}
	}

	public final static function getBrain($name, $default=null) {
		$brain =& self::getArray(self::getConfigValue('bot.file'));
		return isset($brain[$name]) ? $brain[$name] : $default;
	}

}
?>
