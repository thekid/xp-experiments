<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.Resolver', 
    'peer.net.Message'
  );

  /**
   * Resolver that uses PHP's native method
   *
   * @see   php://dns_get_record
   */
  class NativeResolver extends Object implements peer·net·Resolver {
    
    /**
     * Send query for resolution and return nameservers records
     *
     * @param   peer.net.Message query
     * @return  peer.net.Record[] records
     */
    public function send(peer·net·Message $query) {
      $type= 'DNS_'.$query->getType()->name();
      if (!defined($type)) {
        throw new IllegalArgumentException('Unsupported type '.$type);
      }
      
      $results= dns_get_record(this($query->getRecords(), 0), constant($type));
      $records= array();
      foreach ($results as $r) {
        switch ($r['type']) {
          case 'A': 
            $records[]= new ARecord($r['host'], $r['ip']);
            break;

          case 'NS': 
            $records[]= new NSRecord($r['host'], $r['target']);
            break;
          
          case 'CNAME':
            $records[]= new CNAMERecord($r['host'], $r['target']);
            break;

          case 'SOA':
            $records[]= new SOARecord(
              $r['host'], 
              $r['mname'], 
              $r['rname'],
              $r['serial'], 
              $r['refresh'], 
              $r['retry'], 
              $r['expire'], 
              $r['minimum-ttl']
            );
            break;

          case 'PTR': 
            $records[]= new PTRRecord($r['host'], $r['target']);
            break;

          case 'MX': 
            $records[]= new MXRecord($r['host'], $r['pri'], $r['target']);
            break;

          case 'TXT': 
            $records[]= new TXTRecord($r['host'], $r['txt']);
            break;

          case 'AAAA':
            $records[]= new AAAARecord($r['host'], $r['ipv6']);
            break;

          case 'SRV': 
            $records[]= new SRVRecord($r['host'], $r['pri'], $r['weight'], $r['port'], $r['target']);
            break;

          case 'NAPTR':
            $records[]= new NAPTRRecord(
              $r['host'], 
              $r['order'], 
              $r['pref'], 
              strtoupper($r['flags']), 
              $r['services'], 
              $r['regex'], 
              $r['replacement']
            );
            break;
          
          default:
            throw new ProtocolException('Unknown record type '.$r['type']);
        }
      }
      
      return $records;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(*->dns_get_record)';
    }
  }
?>
