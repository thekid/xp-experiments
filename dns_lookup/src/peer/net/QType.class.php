<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum');

  /**
   * DNS query types
   *
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
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
  }
?>
