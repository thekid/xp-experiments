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
      
      // Parse questions
      for ($i= 0; $i < $header['qdcount']; $i++) {
        $domain= $input->readDomain();
        $input->read(4);    // QTYPE, QCLASS -> skip for the moment
      }
      
      // Parse answers
      for ($i= 0; $i < $header['ancount']; $i++) {
        $name= $input->readDomain();
        $r= unpack('ntype/nclass/Nttl/nlength', $input->read(10));

        switch ($r['type']) {
          case 1:   // A
            $ip= implode('.', unpack('Ca/Cb/Cc/Cd', $input->read(4)));

            $record= new ARecord($domain, $ip);
            break;
          
          case 2:   // NS
            $target= $input->readDomain();

            $record= new NSRecord($domain, $target);
            break;

          case 5:    // CNAME
            $target= $input->readDomain();

            $record= new CNAMERecord($domain, $target);
            break;

          case 28:   // AAAA
            $ip= unpack('H*', $input->read(16));

            $record= new AAAARecord($domain, $ip);
            break;
          
          case 15:  // MX
            $pri= unpack('nlevel', $input->read(2));
            $ns= $input->readDomain();
            
            $record= new MXRecord($domain, $pri['level'], $ns);
            break;

          case 16:  // TXT
            $text= $input->read($r['length']);
            
            $record= new TXTRecord($domain, $text);
            break;
          
          case 33:  // SRV
            $data= unpack('npri/nweight/nport', $input->read(6));
            $target= $input->readDomain();
            
            $record= new SRVRecord($domain, $data['pri'], $data['weight'], $data['port'], $target);
            break;

          default:
            throw new ProtocolException('Unknown record type '.$r['type']);
        }
        
        // DEBUG Console::writeLine('RECORD ', $record);
        $return->addRecord($record);
      }

      return $return->getRecords();
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
