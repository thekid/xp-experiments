<?php
/**
 * This file is part of moepbot.
 * @version $Id: MoepBot.class.php,v 1.12 2009/03/15 15:45:09 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * This class extends MoepIrc with ircbot functionality.
 *
 * @package net.moep.irc.moepbot
 * @version 1.0 ($Revision: 1.12 $)
 * @author Sascha 'lupo' Schlindwein <schlind@moep.net>
 */
final class MoepBot extends MoepIrc {

	/** This constant contains the fersion string of the moepBot */
	const VERSION = 'moepBot v1.0 BETA';
	/* This member is the configuration. */

	/* This member is a list of the last active event to detect flooding. */
	private /*array*/    $floodTable = array();

	/**
	 * This is the default constructor.
	 * @param array $propertyFile The initial property file.
	 * @return MoepBot
	 */
	public function MoepBot($configFile) {
		// call super constructor
		$this->MoepIrc();
		// remember start time
		MoepUtil::setEnv('bot.start.time', time());
		// some asciipr0n
		print "\n";
		print "                            ____        _   \n";
		print " _ __ ___   ___   ___ _ __ | __ )  ___ | |_ \n";
		print "| '_ ` _ \ / _ \ / _ \ '_ \|  _ \ / _ \| __|\n";
		print "| | | | | | (_) |  __/ |_) | |_) | (_) | |_ \n";
		print "|_| |_| |_|\___/ \___| .__/|____/ \___/ \__|\n";
		print "                     |_| ".self::VERSION."\n\n";
		#MoepUtil::rotor(100,1);
		try {
			// load config
			$this->loadConfig($configFile);
			// load scripts
			$this->loadScripts();
			// connect
			$this->log('Going online');
			$this->connect();
		} catch (Exception $e) {
			die($e->getMessage()."\n".$e->getTraceAsString()."\n");
		}
	}

	// Logging
	// -------------------------------------------------------------------------

	/**
	 * This method writes a message to the log.
	 * @param string $message The message.
	 */
	private final function log($message) {
		MoepUtil::log("MoepBot $message");
	}


	// Hooks as required by MoepIrc
	// -------------------------------------------------------------------------

	/**
	 * This method implements the hook to handle connections as required by
	 * class MoepIrc.
	 */
	protected final function handleLogin() {
		$this->log("Logged on '".$this->getServerHost()
		."' as '".$this->getConfigValue('bot.nickname')."'");
		MoepUtil::setEnv('bot.connect.time', time());
		// set initial irc-mode
		if ($this->getConfigValue('bot.usermode')) {
			$this->log("Setting mode ".$this->getConfigValue('bot.usermode'));
			$this->sendRaw(':MODE '.$this->getMyNick()
			.' '.$this->getConfigValue('bot.usermode'));
		}
		// autojoin channels on startup
		$this->joinStaticChannels();
	}

	/**
	 * This method implements the hook to handle disconnects as required by
	 * class MoepIrc.
	 */
	protected final function handleDisconnect() {
		if ($this->getConfigValue('bot.stayConnected')) {
			$this->log("Reconnecting...");
			for ($i=5;$i>=0;$i--) {
				$this->log("... waiting {$i}s...");
				sleep(1);
			}
			$this->connect();
			$this->handleDisconnect();
		} else {
			$this->stop();
		}
	}

	/**
	 * This method implements the hook to handle events as required by
	 * class MoepIrc.
	 *
	 * @param MoepEvent $moepEvent
	 */
	protected final function handleEvent(MoepEvent $moepEvent) {

		// check for flooding
		if ($this->isFlooding($moepEvent)) { return; }
		// parse for internal commands
		$runScripts = $this->parseCoreCommand($moepEvent);
		if ($runScripts && $this->getConfigValue('bot.scripts.enabled')) {
			// now give the event into scriptcode
			new MoepScript($moepEvent);
		}
	}

	/**
	 * This method implements the hook to handle heartbeats as required by
	 * class MoepIrc.
	 *
	 * @param boolean $force If true, the heartbeat will execute internal
	 * stuff beatcount independent.
	 */
	protected final function handleHeartBeat($force=false) {

		static $beatCount = 0;
		static $lastBeat = 0;
		$newBeat = time();
		if (0 == $lastBeat) $lastBeat = $newBeat;
		$diff = ($newBeat - $lastBeat).'s';

		if (4815162342<=$beatCount) $beatCount = 0; // THE numbers
		$beatCount++;
		$this->log("<3 HeartBeat #$beatCount, interval $diff, memory ".$this->memInfo());

		if (!($beatCount % 1) || $force) { MoepUtil::saveArrays(); }

		{ $this->floodSchedule(); }

		// now give the heartbeat into scriptcode
		if ($this->getConfigValue('bot.scripts.enabled')) {
			new MoepScript(new MoepEvent($this, null));
		}
		if ($this->getConfigValue('bot.logmsgto')) {
			$this->sendNotice($this->getConfigValue('bot.logmsgto'), $this->memInfo());
		}

		$lastBeat = $newBeat;
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
	public final function getConfigValue($name) {
		return MoepUtil::getConfigValue($name);
	}

	/**
	 * This method returns the config values relating to the given name
	 * prefix.
	 *
	 * This method finalizes the abstract method from MoepIrc.
	 *
	 * @param string $name The name prefix of the config values.
	 * @return array The config values.
	 */
	public final function getConfigList($name) {
		return MoepUtil::getConfigList($name);
	}


	// Interna
	// -------------------------------------------------------------------------

	/**
	 * This method loads the initial configuration from a file.
	 * The work is fairly delegated to class MoepUtil.
	 *
	 * @param string $configFile The path to the config file.
	 */
	private final function loadConfig($configFile) {
		$this->log("Loading config from $configFile");
		MoepUtil::loadConfig($configFile);
	}

	/**
	 * This method loads all scripts as defined in the configuration.
	 */
	private final function loadScripts() {
		if ($this->getConfigValue('bot.scripts.enabled')) {
			$this->log('Scripting is enabled');
			MoepScript::setScripts($this->getConfigList('bot.scripts'));
			MoepScript::loadScripts();
		} else {
			$this->log('Scripting is disabled');
		}
	}

	/**
	 * This method stops the bot as soon as possible.
	 */
	private final function stop() {
		// the final heartbeat (true=force execution)
		$this->handleHeartBeat(true);
		// if still connected, be so kind and tell the server that we go..
		if ($this->isConnected()) $this->disconnect('stop()');
		// bye
		die("stop()\n");
	}

	/**
	 * This method joins all channels as defined in the configfile
	 *
	 */
	private final function joinStaticChannels() {

		$chans = $this->getConfigList('bot.channels');
		if (0 >= count($chans)) {
			$this->log("No channels to join");
		} else {
			foreach ($chans as $chan) {
				$chan = trim($chan);
				if (1 >= strlen($chan)) continue;
				if ('#' != $chan[0]) {
					$chan = "#$chan"; // fix channelname
				}
				$this->log("Joining $chan");
				$this->sendRaw("JOIN $chan");
			}
		}
	}

	/**
	 * This method indicates whether the given mask matches an master of
	 * this bot or not.
	 * Mask look like <nick>!<user>@<host>, the wildcard * can be set
	 * for nick, user and/or host ( "*!schlind@moep.net", e.g.).
	 *
	 * TODO Make finer wildards like schl*!schlind@*.somefoo.moep.net possible!
	 *
	 * @param string $mask
	 * @return boolean True if the mask matches an master.
	 */
	public final function isMaster($mask) {

		if (empty($mask)) return;
		$masters = $this->getConfigList('bot.masters');
		foreach ($masters as $master) {
			if(MoepUtil::masksMatch($mask, $master)) {
				return true; // first match counts
			}
		}
	}


	// Event-Parser
	// -------------------------------------------------------------------------

	/**
	 * This method inspects the given MoepEvent for core commands of the bot.
	 * @param MoepEvent $moepEvent The event.
	 */
	private final function parseCoreCommand(MoepEvent $moepEvent) {

		$runScriptsAfterwards=true;

		$isMe       = $moepEvent->isMe();
		$source     = $moepEvent->getSource();
		$sourceNick = $moepEvent->getSourceNick();
		$sourceUser = $moepEvent->getSourceUser();
		$sourceHost = $moepEvent->getSourceHost();
		$targetNick = $moepEvent->getTargetNick();
		$targetChan = $moepEvent->getTargetChannel();

		if ($moepEvent->isCtcp()) {
			if ('PING' == $moepEvent->getCtcpType()) {
				// PING requests from other clients
				//FIXME pingreply does not work
				// $this->sendCTCPReply($sourceNick, $moepEvent->getMessage());
				$runScriptsAfterwards = false;
			} else if ('VERSION' == $moepEvent->getCtcpType()) {
				// VERSION requests from other clients
				$this->sendCTCPReply($sourceNick,
				$moepEvent->getCtcpType().' '.self::VERSION);
				$runScriptsAfterwards = false;
			}
		} else if ($moepEvent->isPrivmsg()) {

			// check user
			$isMaster = $this->isMaster($source);

			#if ($isMaster) $this->logDebug("~~~ $source is a master ~~~");

			//
			// master query commands
			//
			if ($this->isMaster($source) && $moepEvent->isOnPrivate()) {
				if ($moepEvent->isCommand('raw', true)) {
					// let the bot send a raw line to the server (hazardous)
					$this->sendRaw($moepEvent->getMessage());
					$runScriptsAfterwards = false;
				} 
				
				else if ($moepEvent->isCommand('dump-arrays', true)) {
					// let the bot dump the current db into the log
					MoepUtil::dumpArrays();
					$runScriptsAfterwards = false;
				}

				else if ($moepEvent->isCommand('dump-bot', true)) {
					// let the bot dump its object into the log
					#var_dump($this);
					print_r($this);
					$runScriptsAfterwards = false;
				} 
				
				else if ($moepEvent->isCommand('ping', true)
				||         $moepEvent->isCommand('.', true)) {
					$this->log("[heartbeat] $targetChan by $source");
					$this->handleHeartBeat(true);
					$this->sendNotice($moepEvent->getSourceNick(), 'pong');
					$runScriptsAfterwards = false;
				}

				else if ($moepEvent->isCommand('rehash', true)
				||         $moepEvent->isCommand('#', true)) {
					// reload configuration and scripts
					$this->log("[rehash] $targetChan by $source");
					$this->sendNotice($moepEvent->getSourceNick(), "rehashing...");
					$this->loadConfig(MoepUtil::getConfigFile());
					$this->loadScripts();
					$this->handleHeartBeat(true);
					$this->sendNotice($moepEvent->getSourceNick(), 'rehashed');
					$runScriptsAfterwards = false;
				}

				else if ($moepEvent->isCommand('die', true)) {
					// let the bot stop immediately
					$this->log("[die] $targetChan by $source");
					$this->sendNotice($moepEvent->getSourceNick(), 'killed softly...');
					$this->sendRaw("QUIT *yiiaargh*");
					$this->stop();
					$runScriptsAfterwards = false;
				}

				else if ($moepEvent->isCommand('reconnect', true)) {
					// let the bot reconnect
					$this->sendNotice($moepEvent->getSourceNick(), 'reconnecting..');
					$this->log("[reconnect] $targetChan by $source");
					$this->disconnect('reconnecting...');
					$this->connect();
				}

				else if ($moepEvent->isCommand('restart', true)) {
					//TODO implement restarting with fork
				}

				else if ($moepEvent->isCommand('set_ini', true)) {
					$msg = $moepEvent->getMessage();
					$msg = explode('=', $msg);
					$k = isset($msg[0]) ? $msg[0] : null;
					$v = isset($msg[1]) ? $msg[1] : null;
					if (!empty($k)) {
						ini_set($k,$v);
					}
				} 
				
				else if ($moepEvent->isCommand('get_ini', true)) {
					$k = $moepEvent->getMessage();
					if (!empty($k)) {
						$v = ini_get($k);
					}
					$this->sendNotice($moepEvent->getSourceNick(), "INI $k = $v");
				}

				else if ($moepEvent->isCommand('set_env', true)) {
					$msg = $moepEvent->getMessage();
					$msg = explode('=', $msg);
					$k = isset($msg[0]) ? trim($msg[0]) : null;
					$v = isset($msg[1]) ? trim($msg[1]) : null;
					if (!empty($k)) {
						$this->log("$k = $v");
						MoepUtil::setEnv($k,$v);
					}
				}

				else if ($moepEvent->isCommand('get_env', true)) {
					$k = trim($moepEvent->getMessage());
					$v = MoepUtil::getEnv($k);
					$this->log("$k = $v");
					$this->sendNotice($moepEvent->getSourceNick(), "ENV $k = $v");
				}
			}

			//
			// public channel commands available for all users
			//
			if ($moepEvent->isOnChannel()) {
				if ($moepEvent->isCommand('cycle')) {
					// cycle a channel
					$this->log("[cycling] $targetChan by $source");
					$this->sendRaw("PART $targetChan :cycling...");
					#sleep(is_numeric($moepEvent->getMessage()) ? intval($moepEvent->getMessage()) : 1);
					$this->sendRaw("JOIN $targetChan");
					$runScriptsAfterwards = false;
				}

				else if ($moepEvent->isCommand('part')) {
					// part a channel
					$this->log("[parting] $targetChan by $source");
					$this->sendRaw("PART $targetChan :tschau $sourceNick!");
					$runScriptsAfterwards = false;
				}

				else if ($moepEvent->isCommand('uptime')) {
					// uptime
					$this->log("[uptime] $targetChan by $source");
					$botTime = MoepUtil::ago(MoepUtil::getEnv('bot.start.time'));
					$ircTime = MoepUtil::ago(MoepUtil::getEnv('bot.connect.time'));
					$serverName = $this->getServerHost();
					$uptime = "up $botTime, $serverName $ircTime ("
					.self::VERSION.', '.$this->phpInfo().', '.$this->memInfo().')';
					$this->sendAction($targetChan, $uptime);
					$runScriptsAfterwards = false;
				}
			}
			if ($moepEvent->isOnChannel() && $moepEvent->isCommand('help')
			|| $moepEvent->isOnPrivate() && $moepEvent->isCommand('help', true)) {
				$this->sendAction($sourceNick,
					"$sourceNick, Du kannst im Kanal folgende Befehle benutzen:");
				$this->sendMessage($sourceNick,
					'"!uptime" - zeigt Informationen zu meiner Laufzeit.');
				$this->sendMessage($sourceNick,
					'"!cycle"  - ich verlasse den Kanal und komme gleich wieder.');
				$this->sendMessage($sourceNick,
					'"!part"  - ich verlasse den Kanal und komme erst wieder, wenn man mich per /invite einlaedt.');

				if ($this->isMaster($source)) {
					$this->sendAction($sourceNick,
					"Meister, Du kannst im Query folgende Befehle benutzen:");
					$this->sendMessage($sourceNick,
					'"rehash"    - Konfiguration und Skripte neu laden');
					$this->sendMessage($sourceNick,
					'"raw"       - alles nach raw schreibe ich auf den Socket');
					$this->sendMessage($sourceNick,
					'"reconnect" - ich verbinde mich neu mit dem Server');
					$this->sendMessage($sourceNick,
					'"ping"      - ich rufe den internen HeartBeat auf');
					$this->sendMessage($sourceNick,
					'"die"       - ich sterbe');
				}
			}
		}

		return $runScriptsAfterwards;
	}

	// Flood protection (kind of)
	// -------------------------------------------------------------------------

	/**
	 * This method indicates whether the bot is being flooded by the current
	 * event.
	 * 
	 * @internal Each user may post X lines in Y seconds on each channel or 
	 * query with the bot until being ignored for Z seconds. The values for X, 
	 * Y and Z are set by configuration, see "bot.flood.*".
	 *
	 * @return boolean True if the bot is being flooded.
	 */
	private final function isFlooding(MoepEvent $moepEvent) {

		// several events are not checked for flooding..
		if ($this->isMaster($moepEvent->getSource())) return false;
		if ($moepEvent->isFromServer()) return false;
		if ($moepEvent->isMode())       return false;
		if ($moepEvent->isKick())       return false;
		if ($moepEvent->isTopic())      return false;
		if ($moepEvent->isMe())         return false;

		$source = $moepEvent->getSource();
		$target = $moepEvent->getTargetChannel();
		if (empty($target)) { $target = '_query_'; }

		// get a handle reference for the current matching flood table entry
		$handle =& $this->floodTable[$target][$source];
		// create new handle, if not exists in flood table
		if (!is_array($handle)) { $handle = array(); }

		// initially nothing is ignored
		$isIgnored = false;
		// get current timestamp
		$now = time();
		
		if (!isset($handle['lines'])) {
			// handle has initial contact, 1st line
			$handle['lines']  = 1;
			$handle['ltime']  = $now;
			$handle['source'] = $moepEvent->getSource();
		} else if (isset($handle['flood'])) {
			// handle is currently being ignored
			$isIgnored = true;
		} else if (isset($handle['ltime'])) {
			// handle already had first contact, reconized again, count lines
			$maxLines  = $this->getConfigValue('bot.flood.lines');
			$inSeconds = $this->getConfigValue('bot.flood.seconds');
			$timeleft = $now - $handle['ltime'];
			if ($timeleft <= $inSeconds) {
				if ($maxLines <= ++$handle['lines']) {
					// handle hits the barrier, ignore
					$handle['flood'] = $now;
					$this->log("[floodcheck] IGNORING <$source> NOW ($target)");
					#$this->log("[floodcheck] SILENCE +$source");
					$this->sendRaw("SILENCE +$source");
					$isIgnored = true;
				}
			} else {
				// last entry expired, start over
				$handle['lines'] = 1;
				$handle['ltime'] = $now;
			}
		}

		return $isIgnored;
	}

	/**
	 * This method unignores expired users.
	 */
	private final function floodSchedule() {
		$now = time();
		$floodTable = $this->floodTable;
		$ignoreTime = $this->getConfigValue('bot.flood.ignoretime');
		#$this->log("[floodschedule] checking entries...");
		#print_r($floodTable);
		foreach ($floodTable as $target => $data) {
			#$this->log("[floodschedule] $target checking entries...");
			foreach ($data as $source => $void) {
				if (isset($this->floodTable[$target][$source]['flood'])) {
					#$this->log("[floodschedule] $target $source checking...");
					$startedIgnoreTime = $this->floodTable[$target][$source]['flood'];
					if ($now - $startedIgnoreTime >= $ignoreTime) {
						#$this->log("[floodschedule] UNIGNORING <$source> NOW ($target)");
						$this->log("[floodschedule] SILENCE -".$source);
						$this->sendRaw("SILENCE -".$source);
						unset($this->floodTable[$target][$source]);
					}
				}
				#$this->log("[floodschedule] $target done.");
			}
		}
	}

	// Additional features
	// -------------------------------------------------------------------------

	/**
	 * This method returns a string with the current php version and memory info.
	 * @return string the current php version and memory info.
	 */
	private final function phpInfo() {
		return 'PHP '.substr(phpversion(),0,strpos(phpversion(), '-'));
	}

	private final function memInfo() {

		static $lastMemUsage = null;

		$memLimit = ini_get('memory_limit');
		if (strstr($memLimit,'M')) {
			$memLimit = str_replace('M','',$memLimit) * 1024 * 1024;
		}
		$thisMemUsage = memory_get_usage();
		$diff = $thisMemUsage - $lastMemUsage;
		$lastMemUsage = $thisMemUsage;
		#$this->log("$thisMemUsage - $lastMemUsage");

		$percent = round(100 * $thisMemUsage / $memLimit, 2);
		$thisMemUsage = round($thisMemUsage  / 1024, 2).'kB';
		#$memLimit     = round($memLimit      / 1024, 2).'kB';
		#$diff     = round($diff      / 1024, 3).'';
		if (0 <= $diff) $diff = "+$diff".'B';
		else $diff = "$diff".'B';

		return "$thisMemUsage $percent% $diff";
	}

}
?>
