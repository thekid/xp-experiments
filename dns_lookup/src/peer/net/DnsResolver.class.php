<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.Resolver', 
    'peer.net.Message', 
    'peer.UDPSocket',
    'peer.ProtocolException',
    'peer.net.Input'
  );

  /**
   * Resolver that works against a single DNS server
   *
   * @see   rfc://1035
   */
  class DnsResolver extends Object implements peer·net·Resolver {
    protected $sock= NULL;
    protected $domain= NULL;
    protected $search= NULL;
  
    /**
     * Constructor
     *
     * Usage with sockets
     * ------------------
     * <code>
     *   $r= new DefaultResolver(new UDPSocket('172.19.0.1', 53));
     * </code>
     *
     * Convenience
     * -----------
     * <code>
     *   $r= new DefaultResolver('172.19.0.1');
     *   $r= new DefaultResolver('172.19.0.1', 53);
     * </code>
     *
     * @param   var endpoint
     * @param   int port
     */
    public function __construct($endpoint, $port= 53) {
      if ($endpoint instanceof Socket) {
        $this->sock= $endpoint;
      } else {
        $this->sock= new UDPSocket($endpoint, $port);
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
      
      // Connect if necessary
      if (!$this->sock->isConnected()) $this->sock->connect();
      
      // Qualify name
      $name= $records[0]->getName();
      $names= array($name => TRUE);
      $this->domain && $names[$name.'.'.$this->domain]= TRUE;
      foreach ($this->search as $domain) {
        $names[$name.'.'.$domain]= TRUE;
      }

      $return= xp::null();
      foreach ($names as $name => $lookup) {
        // DEBUG Console::write($name);

        // Compose message
        $send= pack(
          'nnnnnn', 
          $query->getId(), 
          $query->getOpcode() | $query->getFlags(),
          1,                // QDCOUNT
          0,                // ANCOUNT
          0,                // NSCOUNT
          0                 // ARCOUNT
        );
        foreach (explode('.', $name) as $label) {
          $send.= pack('C', strlen($label)).$label;
        }
        $send.= "\0";
        $send.= pack(
          'nn', 
          $records[0]->getQType()->ordinal(),
          $records[0]->getQClass()->ordinal()
        );

        // Communication
        $this->sock->write($send);
        $header= unpack('nid/c1op/c1flags/nqdcount/nancount/nnscount/narcount', $this->sock->readBinary(12));

        // Verify header id
        if ($header['id'] !== $query->getId()) {
          throw new ProtocolException('Expected answer for #'.$query->getId().', have '.$header['id']);
        }

        $return= new peer·net·Message($header['id']);
        $return->setOpcode($header['op']);
        $return->setFlags($header['flags']);

        // Read rest of packet (max. 512 bytes for entire message!)
        $this->sock->setBlocking(FALSE);
        $input= '';
        while ($chunk= $this->sock->readBinary(500)) {
          $input.= $chunk;
        }
        $this->sock->setBlocking(TRUE);
        
        // DEBUG Console::writeLine(' => ', $header['flags']);
        
        // NXDOMAIN -> continue to next in list
        if (3 === ($header['flags'] & 0xF)) continue;
        
        $input= new peer·net·Input($input);
        // DEBUG Console::writeLine('INPUT  ', $input);

        // Parse questions
        for ($i= 0; $i < $header['qdcount']; $i++) {
          $domain= $input->readDomain();
          $r= unpack('ntype/nclass', $input->read(4));
          $return->addRecord(Sections::QUESTION, new peer·net·Query(
            $domain,
            QType::withId($r['type']),
            QClass::withId($r['class'])
          ));
        }

        // Parse answer section 
        for ($i= 0; $i < $header['ancount']; $i++) {
          $return->addRecord(Sections::ANSWER, $input->readRecord());
        }

        // Parse authority section
        for ($i= 0; $i < $header['nscount']; $i++) {
          $return->addRecord(Sections::AUTHORITY, $input->readRecord());
        }

        // Parse additional records section
        for ($i= 0; $i < $header['arcount']; $i++) {
          $return->addRecord(Sections::ADDITIONAL, $input->readRecord());
        }
        break;
      }

      return $return;
    }

    /**
     * Set domain
     *
     * @param   string name
     */
    public function setDomain($name) {
      $this->domain= $name;
    }

    /**
     * Set search list
     *
     * @param   string[] domains
     */
    public function setSearch($domains) {
      $this->search= $domains;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(*->'.$this->sock->toString().')';
    }
    
    /**
     * Destructor. Ensures connection is closed.
     *
     */
    public function __destruct() {
      if ($this->sock->isConnected()) {
        $this->sock->close();
      }
    }
  }
?>
