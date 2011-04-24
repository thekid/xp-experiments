<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'peer.net';

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class peer·net·Message extends Object {

    protected static function rid() {
      static $rid= 1;

      if (++$rid > 65535) $rid= 1;
      return $rid;
    }
    
    public function getBytes() {
      $packet= '';
      $packet.= "\x7E";
      $packet.= "\xFF\x03";
      $packet.= "\x00\x21";
      $packet.= "\x45\x00\x00\x40\x00\x02\x00\x00\x3C\x11\xE0\x30\xCE\xD9\x8F\x1F\xC7\xB6\x78\xCB\x04\x6D";
      $packet.= "\x00\x35\x00\x2C\x0D\x54";
      $packet.= "\x00\x02\x01\x00\x00\x01\x00\x00\x00\x00\x00\x00";
      $packet.= "\x04\x70\x6F\x70\x64\x02\x69\x78\x06\x6E\x65\x74\x63\x6F\x6D\x03\x63\x6F\x6D\x00\x00\x01\x00\x01";
      $packet.= "\xC7\x00";
      $packet.= "\x7E";

      return $packet;
    }
  }
?>
