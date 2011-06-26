<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * DNS query types
   *
   * @test  xp://net.xp_framework.unittest.peer.net.QTypeTest
   * @see   http://en.wikipedia.org/wiki/List_of_DNS_record_types
   * @see   rfc://1035 Section "3.2.2. TYPE values" and "3.2.3 QTYPE values".
   * @see   rfc://2782 A DNS RR for specifying the location of services (DNS SRV)
   * @see   rfc://3596 DNS Extensions to Support IP Version 6
   */
  class QType extends Enum {
    public static 
      $A, 
      $NS, 
      $CNAME, 
      $SOA, 
      $PTR, 
      $MX, 
      $TXT, 
      // $RP,
      // $AFSDB,
      // $SIG,
      // $KEY,
      $AAAA, 
      // $LOC
      $SRV, 
      $NAPTR, 
      // $KX,
      // $CERT,
      // $DNAME,
      // $APL,
      // $DS,
      // $SSHFP,
      // $IPSECKEY,
      // $RRSIG,
      // $NSEC,
      // $DNSKEY,
      // $DHCID,
      // $NSEC3,
      // $NSEC3PARAM,
      // $HIP,
      // $SPF,
      // $TKEY,
      // $TSIG,
      // $TA,
      // $DLV,
      
      // $AXFR,
      // $IXFR,
      // $OPT,
      $ANY;
    
    static function __static() {
      self::$A= new self(1, 'A');
      self::$NS= new self(2, 'NS');
      self::$CNAME= new self(5, 'CNAME');
      self::$SOA= new self(6, 'SOA');
      self::$PTR= new self(12, 'PTR');
      self::$MX= new self(15, 'MX');
      self::$TXT= new self(16, 'TXT');
      self::$AAAA= new self(28, 'AAAA');
      self::$SRV= new self(33, 'SRV');
      self::$NAPTR= new self(35, 'NAPTR');

      self::$ANY= new self(255, 'ANY');
    }

    /**
     * Returns a QType instance for a given numeric qtype
     *
     * @param   int qtype
     * @return  peet.net.QType
     * @throws  lang.IllegalArgumentException if this qtype is not known
     */
    public static function withId($qtype) {
      static $map= NULL; if (NULL === $map) $map= array(
        1   => self::$A,
        2   => self::$NS,
        5   => self::$CNAME,
        6   => self::$SOA,
        12  => self::$PTR,
        15  => self::$MX,
        16  => self::$TXT,
        28  => self::$AAAA,
        33  => self::$SRV,
        35  => self::$NAPTR,
        255 => self::$ANY,
      );

      if (!isset($map[$qtype])) {
        throw new IllegalArgumentException('No such qtype #'.$qtype);
      }
      return $map[$qtype];
    }

    /**
     * Creates a QType instance from a given 
     *
     * @param   string name
     * @return  peer.net.QType
     * @throws  lang.IllegalArgumentException in case the enum member does not exist
     */
    public static function named($name) {
      return parent::valueOf(new XPClass(__CLASS__), $name);
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
