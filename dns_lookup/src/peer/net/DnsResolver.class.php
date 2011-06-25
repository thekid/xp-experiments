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
     * @return  peer.net.Record[] records
     */
    public function send(peer·net·Message $query) {
      if (!$this->sock->isConnected()) {
        $this->sock->connect();
      }

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
      
      //XXX RECORD
      //foreach ($this->records as $record) {
      //  $packet.= $record->getBytes();
      //}
      
      // 1 record {{{
      foreach (explode('.', this($query->getRecords(), 0)) as $label) {
        $send.= pack('C', strlen($label)).$label;
      }
      $send.= "\0";
      // }}}
      
      $send.= pack(
        'nn', 
        $query->getType()->ordinal(),    // QTYPE
        1                                // QCLASS ("IN")
      );
      // }}}

      // Communication
      $this->sock->write($send);
      $header= unpack('nid/nspec/nqdcount/nancount/nnscount/narcount', $this->sock->readBinary(12));
      
      // Verify header id
      if ($header['id'] !== $query->getId()) {
        throw new ProtocolException('Expected answer for #'.$query->getId().', have '.$header['id']);
      }
      $return= new peer·net·Message($header['id']);

      // Read rest of packet (max. 512 bytes for entire message!)
      $this->sock->setBlocking(FALSE);
      $input= '';
      while ($chunk= $this->sock->readBinary(500)) {
        $input.= $chunk;
      }
      $input= new peer·net·Input($input);
      // DEBUG Console::writeLine('INPUT  ', $input);
      
      // Parse questions
      for ($i= 0; $i < $header['qdcount']; $i++) {
        $domain= $input->readDomain();
        $input->read(4);    // QTYPE, QCLASS -> skip for the moment
      }
      
      // Parse answers
      for ($i= 0; $i < $header['ancount']; $i++) {
        $record= $input->readRecord();

        // DEBUG Console::writeLine('RECORD ', $record);
        $return->addRecord($record);
      }

      return $return->getRecords();
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
