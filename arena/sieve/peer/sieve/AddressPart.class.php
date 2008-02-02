<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * (Insert class' description here)
   *
   * @see      reference
   * @purpose  purpose
   */
  class AddressPart extends Enum {
    public static $all, $domain, $localpart;
    
    static function __static() {
      self::$all= new self(0, 'all');
      self::$domain= new self(1, 'domain');
      self::$localpart= new self(2, 'localpart');
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
