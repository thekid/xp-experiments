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
     * @return  peer.net.Message The response
     */
    public function send(peer·net·Message $query) {
      $records= $query->getRecords();
      $type= 'DNS_'.$records[0]->getQType()->name();
      if (!defined($type)) {
        throw new IllegalArgumentException('Unsupported type '.$type);
      }
      
      $auth= $add= NULL;
      $query= dns_get_record($records[0]->getName(), constant($type), $auth, $add);

      $return= new peer·net·Message(-1);
      $return->setOpcode(-1);
      $results= array_merge(is_array($query) ? $query : array(), $auth, $add);

      // NXDOMAIN is the only input we can distinguish
      if (empty($results)) {
        $return->setFlags(-125);    
        return $return;
      }

      foreach ($results as $r) {
        switch ($r['type']) {
          case 'A': 
            $return->addRecord(new ARecord($r['host'], $r['ttl'], $r['ip']));
            break;

          case 'NS': 
            $return->addRecord(new NSRecord($r['host'], $r['ttl'], $r['target']));
            break;
          
          case 'CNAME':
            $return->addRecord(new CNAMERecord($r['host'], $r['ttl'], $r['target']));
            break;

          case 'SOA':
            $return->addRecord(new SOARecord(
              $r['host'], 
              $r['mname'], 
              $r['rname'],
              $r['serial'], 
              $r['refresh'], 
              $r['retry'], 
              $r['expire'], 
              $r['minimum-ttl']
            ));
            break;

          case 'PTR': 
            $return->addRecord(new PTRRecord($r['host'], $r['ttl'], $r['target']));
            break;

          case 'MX': 
            $return->addRecord(new MXRecord($r['host'], $r['ttl'], $r['pri'], $r['target']));
            break;

          case 'TXT': 
            $return->addRecord(new TXTRecord($r['host'], $r['ttl'], $r['txt']));
            break;

          case 'AAAA':
            $return->addRecord(new AAAARecord($r['host'], $r['ttl'], $r['ipv6']));
            break;

          case 'SRV': 
            $return->addRecord(new SRVRecord($r['host'], $r['ttl'], $r['pri'], $r['weight'], $r['port'], $r['target']));
            break;

          case 'NAPTR':
            $return->addRecord(new NAPTRRecord(
              $r['host'], 
              $r['order'], 
              $r['pref'], 
              strtoupper($r['flags']), 
              $r['services'], 
              $r['regex'], 
              $r['replacement']
            ));
            break;
          
          default:
            throw new ProtocolException('Unknown record type '.$r['type']);
        }
      }
      
      return $return;
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
