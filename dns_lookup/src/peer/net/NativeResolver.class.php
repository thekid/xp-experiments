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
  
    protected function asRecord($r) {
      switch ($r['type']) {
        case 'A': 
          return new ARecord($r['host'], $r['ttl'], $r['ip']);

        case 'NS': 
          return new NSRecord($r['host'], $r['ttl'], $r['target']);

        case 'CNAME':
          return new CNAMERecord($r['host'], $r['ttl'], $r['target']);

        case 'PTR': 
          return new PTRRecord($r['host'], $r['ttl'], $r['target']);

        case 'MX': 
          return new MXRecord($r['host'], $r['ttl'], $r['pri'], $r['target']);

        case 'TXT': 
          return new TXTRecord($r['host'], $r['ttl'], $r['txt']);

        case 'AAAA':
          return new AAAARecord($r['host'], $r['ttl'], $r['ipv6']);

        case 'SOA':
          return new SOARecord(
            $r['host'], 
            $r['mname'], 
            $r['rname'],
            $r['serial'], 
            $r['refresh'], 
            $r['retry'], 
            $r['expire'], 
            $r['minimum-ttl']
          );

        case 'SRV': 
          return new SRVRecord(
            $r['host'], 
            $r['ttl'], 
            $r['pri'], 
            $r['weight'], 
            $r['port'], 
            $r['target']
          );

        case 'NAPTR':
          return new NAPTRRecord(
            $r['host'], 
            $r['order'], 
            $r['pref'], 
            strtoupper($r['flags']), 
            $r['services'], 
            $r['regex'], 
            $r['replacement']
          );

        default:
          throw new ProtocolException('Unknown record type '.$r['type']);
      }
    }
    
    /**
     * Send query for resolution and return nameservers records
     *
     * @param   peer.net.Message query
     * @return  peer.net.Message The response
     */
    public function send(peer·net·Message $query) {

      // Check for multiple records, which, in real life, doesn't work
      // See http://www.mail-archive.com/comp-protocols-dns-bind@isc.org/msg00165.html
      // See http://www.maradns.org/multiple.qdcount.html
      $records= $query->getRecords(Sections::QUESTION);
      if (sizeof($records) > 1) {
        throw new IllegalArgumentException('Multiple questions don\'t work with most servers');
      }

      $type= 'DNS_'.$records[0]->getQType()->name();
      if (!defined($type)) {
        throw new IllegalArgumentException('Unsupported type '.$type);
      }
      
      $auth= $add= array();
      $query= dns_get_record($records[0]->getName(), constant($type), $auth, $add);
      $results= is_array($query) ? $query : array();

      $return= new peer·net·Message(-1);
      $return->setOpcode(-1);
      $return->addRecord(Sections::QUESTION, $records[0]);

      // NXDOMAIN is the only input we can distinguish
      if (empty($results)) {
        $return->setFlags(-125);    
        return $return;
      }

      // Parse answer section 
      foreach ($results as $r) {
        $return->addRecord(Sections::ANSWER, $this->asRecord($r));
      }

      // Parse authority section
      foreach ($auth as $r) {
        $return->addRecord(Sections::AUTHORITY, $this->asRecord($r));
      }

      // Parse additional records section
      foreach ($add as $r) {
        $return->addRecord(Sections::ADDITIONAL, $this->asRecord($r));
      }
      
      return $return;
    }

    /**
     * Set domain
     *
     * @param   string name
     */
    public function setDomain($name) {
      // NOOP, built-in function takes care of this
    }

    /**
     * Set search list
     *
     * @param   string[] domains
     */
    public function setSearch($domains) {
      // NOOP, built-in function takes care of this
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
