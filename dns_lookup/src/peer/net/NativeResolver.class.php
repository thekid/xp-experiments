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
      foreach ($results as $result) {
        switch ($result['type']) {
          case 'A': 
            $records[]= new ARecord($result['host'], $result['ip']);
            break;

          case 'NS': 
            $records[]= new NSRecord($result['host'], $result['target']);
            break;
          
          case 'CNAME':
            $records[]= new CNAMERecord($result['host'], $result['target']);
            break;

          case 'AAAA':
            $records[]= new CNAMERecord($result['host'], $result['ipv6']);
            break;

          case 'MX': 
            $records[]= new MXRecord($result['host'], $result['pri'], $result['target']);
            break;

          case 'TXT': 
            $records[]= new TXTRecord($result['host'], $result['txt']);
            break;

          case 'SRV': 
            $records[]= new SRVRecord($result['host'], $result['pri'], $result['weight'], $result['port'], $result['target']);
            break;

          // TODO: Implement rest
          
          default:
            throw new ProtocolException('Unknown record type '.$result['type']);
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
  
