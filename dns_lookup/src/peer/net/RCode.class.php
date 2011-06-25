<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * DNS rcodes
   *
   * @see   rfc://1035 Section "4.1.1. Header section format"
   */
  class RCode extends Enum {
    public static 
      $SUCCESS,
      $FORMERR,
      $SERVAIL,
      $NXDOMAIN,
      $NOTIMPL,
      $REFUSED,
      $YXDOMAIN,
      $YXRRSET,
      $NXRRSET,
      $NOTAUTH,
      $NOTZONE,
      $BADVERS,
      $BADSIG,
      $BADTIME,
      $BADMODE;
    
    static function __static() {
      self::$SUCCESS= new self(0, 'SUCCESS');
      self::$FORMERR= new self(1, 'FORMERR');
      self::$SERVAIL= new self(2, 'SERVAIL');
      self::$NXDOMAIN= new self(3, 'NXDOMAIN');
      self::$NOTIMPL= new self(4, 'NOTIMPL');
      self::$REFUSED= new self(5, 'REFUSED');
      self::$YXDOMAIN= new self(6, 'YXDOMAIN');
      self::$YXRRSET= new self(7, 'YXRRSET');
      self::$NXRRSET= new self(8, 'NXRRSET');
      self::$NOTAUTH= new self(9, 'NOTAUTH');
      self::$NOTZONE= new self(10, 'NOTZONE');
      self::$BADVERS= new self(16, 'BADVERS');
      self::$BADSIG= new self(17, 'BADSIG');
      self::$BADTIME= new self(18, 'BADTIME');
      self::$BADMODE= new self(19, 'BADMODE');
    }
    
    /**
     * Returns an RCode instance for a given numeric rcode
     *
     * @param   int rcode
     * @return  peet.net.RCode
     * @throws  lang.IllegalArgumentException if this rcode is not known
     */
    public static function forCode($rcode) {
      static $map= NULL; if (NULL === $map) $map= array(
         0 => self::$SUCCESS,
         1 => self::$FORMERR,
         2 => self::$SERVAIL,
         3 => self::$NXDOMAIN,
         4 => self::$NOTIMPL,
         5 => self::$REFUSED,
         6 => self::$YXDOMAIN,
         7 => self::$YXRRSET,
         8 => self::$NXRRSET,
         9 => self::$NOTAUTH,
        10 => self::$NOTZONE,
        16 => self::$BADVERS,
        17 => self::$BADSIG,
        18 => self::$BADTIME,
        19 => self::$BADMODE,
      );

      if (!isset($map[$rcode])) {
        throw new IllegalArgumentException('No such rcode #'.$rcode);
      }
      return $map[$rcode];
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
