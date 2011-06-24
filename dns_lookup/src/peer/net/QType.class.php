<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * DNS query types
   *
   * @see   rfc://1035 Section "3.2.2. TYPE values" and "3.2.3 QTYPE values".
   */
  class QType extends Enum {
    public static 
      $A, 
      $NS, 
      // Obsolete $MD,
      // Obsolete $MF,
      $CNAME, 
      $SOA, 
      // Experimental $MB,
      // Experimental $MG,
      // Experimental $MR,
      // Experimental $NULL,
      $WKS,
      $PTR, 
      $HINFO, 
      $MINFO, 
      $MX, 
      $TXT, 

      $A6, 
      $SRV, 
      $NAPTR, 
      $AAAA, 
      
      $ANY;
    
    static function __static() {
      self::$A= new self(1, 'A');
      self::$NS= new self(2, 'NS');
      self::$CNAME= new self(5, 'CNAME');
      self::$SOA= new self(6, 'SOA');
      self::$WKS= new self(11, 'WKS');
      self::$PTR= new self(12, 'PTR');
      self::$HINFO= new self(13, 'HINFO');
      self::$MINFO= new self(14, 'MINFO');
      self::$MX= new self(15, 'MX');
      self::$TXT= new self(16, 'TXT');

      self::$AAAA= new self(28, 'AAAA');
      self::$SRV= new self(33, 'SRV');
      self::$NAPTR= new self(35, 'NAPTR');
      self::$A6= new self(38, 'A6');
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
