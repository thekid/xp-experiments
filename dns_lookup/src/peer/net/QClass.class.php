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
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
  }
?>
