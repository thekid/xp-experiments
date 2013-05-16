<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * DNS query class
   *
   * @see   http://en.wikipedia.org/wiki/Hesiod_(name_service)
   * @see   http://en.wikipedia.org/wiki/Chaosnet
   */
  class QClass extends Enum {
    public static 
      $IN,
      $CH,
      $HS,
      $NONE,
      $ANY;
    
    static function __static() {
      self::$IN= new self(1, 'IN');
      self::$CH= new self(3, 'CH');
      self::$HS= new self(4, 'HS');
      self::$NONE= new self(254, 'NONE');
      self::$ANY= new self(255, 'ANY');
    }

    /**
     * Returns a QClass instance for a given numeric qclass
     *
     * @param   int qclass
     * @return  peet.net.dns.QClass
     * @throws  lang.IllegalArgumentException if this qclass is not known
     */
    public static function withId($qclass) {
      static $map= NULL; if (NULL === $map) $map= array(
        1   => self::$IN,
        3   => self::$CH,
        4   => self::$HS,
        254 => self::$NONE,
        255 => self::$ANY,
      );

      if (!isset($map[$qclass])) {
        throw new IllegalArgumentException('No such qclass #'.$qclass);
      }
      return $map[$qclass];
    }
    
    /**
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
  }
?>
