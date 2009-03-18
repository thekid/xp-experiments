<?php
/**
 * This file is part of moepbot.
 * @version $Id: MoepIrc.class.php,v 1.7 2009/03/15 15:45:09 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * This class provides simple bidirectional single-thread network socket
 * communictaion and implements essential features of the irc-protocol.
 *
 * @abstract This class is meant as a base for class MoepBot.
 *
 * @package net.moep.irc.moepbot
 * @version 1.0 ($Revision: 1.7 $)
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 */
abstract class MoepIrc {

	/** This constant defines the default irc port (not RFC). */
	const DEFAULT_IRC_PORT = 6667;

	/** This constant defines the delay for the sendqueue in seconds. */
	const QUEUEDELAY = 0.0;

	/* This member is the current nick on the connected server. */
	private /*string*/   $myNick          = null;
	/* This member is the current user on the connected server. */
	private /*string*/   $myUser          = null;
	/* This member is the current host on the connected server. */
	private /*string*/   $myHost          = null;
	/* This member is the current name on the connected server. */
	private /*string*/   $myName          = null;
	/* This member is the current mode on the connected server. */
	private /*string*/   $myMode          = null;
	/* This member indicates whether the bot is connected or not. */
	private /*boolean*/  $isConnected     = false;
	/* This member is the socket to the irc-server. */
	private /*resource*/ $ircSocket       = null;
	/* This member is the name of the current connected server. */
	private /*string*/   $serverHost = null;
	/* This member contains the serversupports information. */
	private /*array*/    $serverISUPPORT  = array();

	/** This is the default constructor. */
	protected function MoepIrc() {
		//NOP
	}

	/**
	 * This method connects to irc-server.
	 */
	protected final function connect() {

		// get initial values from the config
		$nickName  = $this->getConfigValue('bot.nickname');
		$userName  = $this->getConfigValue('bot.username');
		$hostMask  = $this->getConfigValue('bot.hostname');
		$realName  = $this->getConfigValue('bot.realname');
		$ircServer = $this->getConfigValue('bot.serverhost');
		$ircPort   = $this->getConfigValue('bot.serverport');
		$password  = $this->getConfigValue('bot.serverpass');

		// set initial values
		$this->myNick = $nickName;
		$this->myUser = $userName;
		$this->myHost = $hostMask;
		$this->myName = $realName;

		// check port..
		if (empty($ircPort)
		|| !is_numeric($ircPort)
		|| (is_numeric($ircPort)
		&& (0 >= $ircPort || 65555 <= $ircPort))) {
			$port = self::DEFAULT_IRC_PORT; // use default port
		}

		// connect..
		$this->logIrc("Connecting to $ircServer:$ircPort");

		// open the socket as filesocket
		$this->ircSocket = fsockopen($ircServer, $ircPort, $errno, $errstr, 30);

		//FIXME SOCKET-API
		// open the socket via the socket-api: (requires socket-api)
		#$bindIp = $real = $this->getConfigValue('bot.local.ip');
		#$this->ircSocket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		#socket_bind($this->ircSocket, $bindIp);
		#socket_connect($this->ircSocket, $host, $port);

		if (is_resource($this->ircSocket)) {

			// connection established..
			$this->logIrc("Connection established");
			$this->logIrc("Login as $nickName!$userName@$hostMask: $realName");

			/* RFC 1459 4.1 Connection Registration
			 says the login-sequence is PASS -> NICK -> USER */
			if (is_string($password)) {
				$this->logIrc("Sending Password...");
				$this->sendRaw("PASS $password");
			}
			$this->sendRaw("NICK $nickName");
			$this->sendRaw("USER $userName $hostMask $ircServer $realName");

			// wait for the login to proceed...
			if ($this->listen()) {
				// bot is logged in
				$this->isConnected = true;
				// let subclasses handle the login
				$this->handleLogin(); // H O O K
				// listen on the connection..
				$this->listen();
			}
		} else {
			#throw new Exception("Not connected: [$errno] $errstr");
			$this->handleDisconnect();
		}
	}

	/**
	 * Disconnect from irc-server.
	 * @access private
	 */
	protected final function disconnect($reason=null) {
		$this->logIrc("Disconnecting $reason");
		$this->isConnected = false;
		$this->sendRaw("QUIT :$reason");
		if (is_resource($this->ircSocket)) fclose($this->ircSocket);
		$this->ircSocket = null;
		$this->logIrc("Disconnected.");
	}

	/**
	 * This method listens on the socket.
	 *
	 * For the login-event,
	 *
	 * @access private
	 */
	private final function listen() {

		while (!feof($this->ircSocket)) {

			$rawEvent = fgets($this->ircSocket);
			$rawEvent = trim($rawEvent);
			$this->logRawIn($rawEvent);
			$rawParts = explode(' ', $rawEvent);

			//HACK If you need a "faster" hearbeat (like in the great movie
			// "falling down", e.g.), uncomment the following line:
			#$this->handleHeartBeat(); // H O O K

			// PING
			if ("PING" == $rawParts[0]) {
				/* PINGs from the server arrive in a almost constant
				 * interval. Most servers ping theirs clients once in
				 * 1-5 minutes so this gives a good heartbeat to trigger
				 * a scheduler for chronically jobs that do not base on
				 * any specific irc-event. */
				$this->sendRaw("PONG {$rawParts[1]}");
				if ($this->isConnected()) {
					$this->handleHeartBeat(); // H O O K
				}
			}

			// 001
			else if (isset($rawParts[1])
			&& '001' == $rawParts[1]) {

				// 001 is the very first message a server will send to us,
				// as long as our login was successful.
				// This message contains our final accepted nick-, user-
				// and hostname, our irc-identity.
				preg_match('/(.*)\ ((.*)!(.*)@(.*))/', $rawEvent, $matches);
				$matchCount = count($matches);

				$x = explode(':', $matches[1]);
				$x = explode(' ', $x[1]);
				$this->serverHost = $x[0];
				$this->myNick = $matches[$matchCount - 3];
				$this->myUser = $matches[$matchCount - 2];
				$this->myHost = $matches[$matchCount - 1];

				return true; // we are logged in!

			}

			// 005 RPL_ISUPPORT
			else if (isset($rawParts[1])
			&& '005' == $rawParts[1]) {
				// -------------------------------------------------------------
				// 005 RPL_ISUPPORT
				// This message delivers supported modes from the server.
				// We hash the info for later purposes.
				// This irc-code is not yet RFCed. The following information
				// was found in
				// the UnrealIRCd server documentation technical/005.txt.
				//
				// Numeric 005 allows the server to inform the client of any
				// protocol
				// specific features in the IRCd.  The numeric is sent at
				//    connection time
				// immediately after numeric 004. Additionally the numeric is
				//sent when
				// a /version request is made by a local user, for remote users numeric 105
				// is used but contains the same information.
				//
				// Due to the limit imposed by RFC1459 on both the buffer size (512) and the
				// amount of parameters that can be sent in a single command (15) a total of
				// 13 parameters may be specified in each 005. Because of this, a client must
				// be able to accept multiple 005s consecutively. The format for the 005
				// message is as follows:
				//
				// ":" <servername> "005" SPACE <nickname> SPACE <token[=value]>
				// SPACE ... ":are supported by this server"
				//
				// Currently UnrealIRCd supports several tokens that are included in
				// numeric 005. See the documentation for further details.
				// -------------------------------------------------------------

				$server = $this->getServerHost();
				$string = '';
				for ($i=3;$i < count($rawParts); $i++)
				$string.= $rawParts[$i].' ';

				$rawParts = explode(' ', $string);
				foreach ($rawParts as $part) {

					if (empty($part)
					|| 0===strpos($part,':are')
					|| 0===strpos($part,'supported')
					|| 0===strpos($part,'by')
					|| 0===strpos($part,'this')
					|| 0===strpos($part,'server')) continue;

					$part = explode('=', $part);
					if (isset($part[1])) {
						#$this->logIrc('005 '.$part[0].'='.$part[1]);
						$this->serverISUPPORT[$part[0]] = $part[1];
					} else {
						#$this->logIrc('005 '.$part[0]);
						$this->serverISUPPORT[$part[0]] = null;
					}
				}

			}

			// 372 := MOTD
			else if (isset($rawParts[1])
			&& '372' == $rawParts[1]) {
				if (!$this->getConfigValue('bot.skipmotd')) {
					$this->logIrc('MOTD '.$msgType.' '.$moepEvent->getMessage());
				}
			}

			// 432 := Erroneous Nickname
			else if (isset($rawParts[1]) && '433' == $rawParts[1]) {
				$nick = substr($this->getConfigValue('bot.nickname'),0,5).''.rand(1,999);
				$this->logIrc("Nick erroneous, trying random-nick: $nick");
				$this->sendRaw("NICK $nick");
			}

			// 433 := Nickname is already in use
			else if (isset($rawParts[1]) && '433' == $rawParts[1]) {
				if ($this->isConnected() && '' != $this->getConfigValue('bot.nickname')) {
					// if the bot has already a nick, we keep that nick
					$this->logIrc('Requested nickname is in use.');
				} else { // try alternative nick/s
					$nick = substr($this->getConfigValue('bot.nickname'),0,5).''.rand(1,999);
					$this->logIrc("Nick in use, trying random-nick: $nick");
					$this->sendRaw("NICK $nick");
				}

			}

			// any other raw event
			else if (!empty($rawEvent)) {

				$moepEvent = new MoepEvent($this, $rawEvent);

				if ($moepEvent->isMe()) {

					if ($moepEvent->isNick()) {
						// botnick has changed
						$targetNick = $moepEvent->getTargetNick();
						$this->logIrc("\\o/ New own NICK: $targetNick");
						$this->myNick = $targetNick;
					} else if ($moepEvent->isMode()) {
						// mode has changed
						$mode = $moepEvent->getMode();
						$this->logIrc("\\o/ New own MODE: $mode");
						$this->myMode = $moepEvent->getMode();
					}
				}

				// call hook in derived class to let it handle the event
				$this->handleEvent($moepEvent);
			}

			unset($rawEvent, $rawParts, $moepEvent);
		}

		// oops.. somehow.. eeeh.. the socket eeh.. it died..
		if ($this->isConnected) {
			// call hook in derived class to let it handle the disconnect
			$this->handleDisconnect();
		}
	}

	// -------------------------------------------------------------------------
	// Hooks (should be implemented in subclass)
	// -------------------------------------------------------------------------

	abstract public function getConfigValue($name);
	abstract public function getConfigList($name);

	abstract protected function handleLogin();
	abstract protected function handleEvent(MoepEvent $moepEvent);
	abstract protected function handleDisconnect();
	abstract protected function handleHeartBeat();
	abstract protected function isMaster($mask);

	// -------------------------------------------------------------------------
	// Public service
	// -------------------------------------------------------------------------

	/**
	 * This method returns a value from the serversupport information.
	 * (is 005 numeric, see listen())
	 *
	 * @param unknown_type $name
	 * @param unknown_type $default
	 * @return unknown
	 */
	public final function getServerSupport($name, $default=null) {
		return isset($this->serverISUPPORT[$name])
		? $this->serverISUPPORT[$name] : $default;
	}

	/**
	 * This method returns the current nickname of the bot.
	 * @return string The current nickname of the bot.
	 */
	public final function getMyNick() { return $this->myNick; }

	/**
	 * This method returns the current username of the bot.
	 * @return string The current username of the bot.
	 */
	public final function getMyUser() { return $this->myUser; }

	/**
	 * This method returns the current hostname of the bot.
	 * @return string The current hostname of the bot.
	 */
	public final function getMyHost() { return $this->myHost; }

	/**
	 * This method returns the current mask of the bot.
	 * @return string The current mask of the bot.
	 */
	public final function getMe() {
		return $this->getMyNick().'!'.$this->getMyUser().'@'.$this->getMyHost();
	}

	/**
	 * This method indicates whether a irc-connection is established or not.
	 * @return boolean True if a connection is established.
	 */
	public final function isConnected() {
		return $this->isConnected;
	}

	/**
	 * This method returns the hostname of the current connected server.
	 * @return String The hostname of the current connected server.
	 */
	public final function getServerHost() {
		return $this->serverHost;
	}

	// -------------------------------------------------------------------------
	// Send messages to irc
	// -------------------------------------------------------------------------

	/**
	 * This method sends a raw string to the irc-server.
	 * @param string $string The string to send.
	 */
	protected final function sendRaw($string) {
		$string = trim($string);
		if (is_resource($this->ircSocket)) {
			$this->logRawOut($string);
			fputs($this->ircSocket, $string."\r\n");
			#socket_write($this->ircSocket, $string."\r\n")
			usleep(self::QUEUEDELAY * 1000000);
		} else {
			$this->logRawOut("DEAD SOCKET | $string");
		}
	}

	/**
	 * This method sends a PRIVMSG to a channel or a nick.
	 * @param string $to The target of this message.
	 * @param string $$message The message to send.
	 */
	public final function sendMessage($to, $message) {
		if (320 < strlen($message)) {
			$this->sendRaw("PRIVMSG $to :".substr($message,0,320));
			$this->sendMessage($to, substr($message,320, strlen($message)));
		} else {
			$this->sendRaw("PRIVMSG $to :$message");
		}
	}

	/**
	 * This method sends a NOTICE to a channel or a nick.
	 * @param string $to The target of this notice.
	 * @param string $message The notice to send.
	 */
	public final function sendNotice($to, $message) {
		if (320 < strlen($message)) {
			$this->sendRaw("NOTICE $to :".substr($message,0,320));
			$this->sendNotice($to,substr($message,320,strlen($message)));
		} else {
			$this->sendRaw("NOTICE $to :$message");
		}
	}

	/**
	 * This method sends a CTCP-REQUEST to a channel or a nick.
	 * @param string $to The target of this ctcp.
	 * @param string $message The ctcp to send.
	 */
	public final function sendCTCP($to, $message) { $this->sendMessage($to,chr(01)."$message".chr(01)); }

	/**
	 * This method sends a CTCP-REPLY to a channel or a nick.
	 * Instead of being encapsulated in a PRIVMSG like CTCP, the CTCP-REPLY
	 * seems to be sent as NOTICE.
	 * @param string $to The target of this ctcp-reply.
	 * @param string $message The ctcp-reply to send.
	 */
	public final function sendCTCPReply($to, $message) { $this->sendNotice($to,chr(01)."$message".chr(01)); }

	/**
	 * This method sends an CTCP ACTION (/ME) to a channel or a nick.
	 * @param string $to The target of this ctcp-action.
	 * @param string $action The ctcp-action to send.
	 */
	public final function sendAction($to, $action) { $this->sendCTCP($to, "ACTION $action"); }

	/**
	 * This method sets a TOPIC in a channel.
	 * @param string $channel The channel.
	 * @param string $topic The topic.
	 */
	public final function setTopic($channel, $topic) { $this->sendRaw("TOPIC $channel :$topic"); }

	/**
	 * This method sends a JOIN.
	 * @param string $channel The channel.
	 */
	public final function joinChannel($channel) { $this->sendRaw("JOIN $channel"); }

	/**
	 * This method sends a PART.
	 * @param string $channel The channel.
	 * @param string $reason The part-reason.
	 */
	public final function partChannel($channel, $reason) { $this->sendRaw("PART $channel :$reason"); }

	/**
	 * This method sends a NICK.
	 * @param string $newNick The nick.
	 */
	public final function changeNick($newNick) { $this->sendRaw("NICK $newNick"); }

	/**
	 * This method sends a WHO on a channel.
	 * @param string $channel The channel to send the WHO to.
	 */
	public final function sendWho($channel) { $this->sendRaw("WHO $channel"); }

	public final function setAway($reason=null) { $this->sendRaw("AWAY :$reason"); }

	public final function setChannelMode($channel, $mode, $nick=null) { $this->sendRaw("MODE $channel $mode $nick"); }

	public final function kick($nick, $channel, $reason) { $this->sendRaw("KICK $channel $nick :$reason"); }


	// -------------------------------------------------------------------------
	// Logging
	// -------------------------------------------------------------------------

	/** @param string $message The message to log. */
	private final function logIrc($message) {
		MoepUtil::log('MoepIrc '.trim($message));
	}
	/** @param string $message The message to log. */
	private final function logRawIn($message) {
		MoepUtil::log("RAW >> $message");
	}
	/** @param string $message The message to log. */
	private final function logRawOut($message) {
		MoepUtil::log("RAW << $message");
	}

}
?>
