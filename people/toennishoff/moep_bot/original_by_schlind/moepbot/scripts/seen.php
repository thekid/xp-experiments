<?php
/**
 * This file is part of moepbot.
 * @version $Id: seen.php,v 1.3 2009/03/15 14:10:20 schlind Exp $
 * @package net.moep.irc.moepbot
 * @author Sascha 'schlind' Schlindwein <schlind@moep.net>
 * @copyright See LICENSE file
 */
/**
 * $Id: seen.php,v 1.3 2009/03/15 14:10:20 schlind Exp $
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
 * @version $Revision: 1.3 $
 * @author Sascha Schlindwein <phpbot@schlind.org>
 */
if (self::isInit()) {
  // init-phase
} else if (self::isHeartBeat()) {

} else if (self::isNumeric() && 352 == self::getMsgType()) {
  // -------------------------------------------------------------
  // 352 RPL_WHOREPLY RFC1459
  // <channel> <user> <host> <server> <nick> <H|G>[*][@|+]
  // :<hopcount> <real name>
  // 352 RPL_WHOREPLY RFC2812
  // <channel> <user> <host> <server> <nick> ( H|G > [*] [ ( @|+ ) ]
  // :<hopcount> <real name>
  //
  // The RPL_WHOREPLY and RPL_ENDOFWHO pair are used to answer
  // a WHO message.
  // The RPL_WHOREPLY is only sent if there is an appropriate
  // match to the WHO
  // query. If there is a list of parameters supplied with a
  // WHO message, a RPL_ENDOFWHO MUST be sent after processing
  // each list item with <name> being the item.
  // -------------------------------------------------------------

  //        $parts = explode(' ', $moepEvent->getMessage());
  //        $chan = $parts[1];
  //        $user = $parts[2];
  //        $host = $parts[3];
  //        $serv = $parts[4];
  //        $nick = $parts[5];
  //        $flag = $parts[6];
  //        $hopc = substr($parts[7], 1);
  //        $name = $parts[8];
  //        $size = count($parts);
  //        for ($i=9; $i < $size; $i++) {
  //          $name .= ' '.$parts[$i];
  //        }
  //
  //        // Fill nickmatrix.
  //        MoepUtil::setDB('nicks', $nick, 'user', $user);
  //        MoepUtil::setDB('nicks', $nick, 'name', $name);
  //        MoepUtil::setDB('nicks', $nick, 'host', $host);
  //        MoepUtil::setDB('nicks', $nick, 'serv', $serv);
  //        MoepUtil::setDB('nicks', $nick, 'hopc', $hopc);
  //        MoepUtil::setDB('nicks', $nick, 'flag', $flag);
  //
  //        $this->log("352 WHOREPLY for $nick in $chan");
  //

} else if (self::isNumeric() && 353 == self::getMsgType()) {
  // -------------------------------------------------------------
  // 353 RPL_NAMREPLY RFC1459
  // <channel> :[[@|+]<nick> [[@|+]<nick> [...]]]
  // 353 RPL_NAMREPLY RFC2812
  // =|*|@ <channel> :[ @|+ ] <nick> *( <space> [ @|+ ] <nick> )
  //
  // This message contains the description of a joined channel.
  //
  // channel: @ is used for secret channels, * for private
  // channels, = for others (public channels).
  // nick: @ is op, + is voice.
  // -------------------------------------------------------------
  //        $a = explode(':',$moepEvent->getMessage());
  //        $b = explode(' ',$a[1]);
  //        if (false !== strstr($a[0],'@')) {
  //          $c = explode('@',$a[0]);
  //          $c = trim($c[1]);
  //        } else if (false !== strstr($a[0],'*')) {
  //          $c = explode('*',$a[0]);
  //          $c = trim($c[1]);
  //        } else if (false !== strstr($a[0],'=')) {
  //          $c = explode('=',$a[0]);
  //          $c = trim($c[1]);
  //        } else {
  //          $c = '???';
  //        }
  //
  //        // nicks
  //        foreach ($b as $z) {
  //          if (empty($z)) continue;
  //          if ('@' == $z[0] || '+' == $z[0]) {
  //            $nick = substr($z,1); // is op or voice
  //          } else {
  //            $nick = $z; // is regular
  //          }
  //          MoepUtil::setDB($c, 'ison', $nick, time());
  //        }
  //        $this->log("353 Received description of $c");
  //        // sending a /WHO on the channel -> case 352
  //        $this->log("    Sending /WHO on $c");
  //        $this->sendRaw("WHO $c");
  #self::sendWho($c);

}
?>
