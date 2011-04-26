<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.Resolver', 
    'peer.net.Message', 
    'peer.UDPSocket',
    'peer.ProtocolException'
  );

  /**
   * Resolver that works against a single DNS server
   *
   */
  class DefaultResolver extends Object implements peer·net·Resolver {
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
     * (Insert method's description here)
     *
     * @param   peer.net.Message query
     * @return  
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
      $send.= pack(
        'nn', 
        $query->getType(),    // QTYPE
        1                     // QCLASS
      );
      // }}}

      // Communication
      $this->sock->write($send);
      $header= unpack('nid/nspec/nqdcount/nancount/nnscount/narcount', $this->sock->readBinary(12));
      Console::writeLine($header);
      
      // Verify header id
      if ($header['id'] !== $query->getId()) {
        throw new ProtocolException('Expected answer for #'.$query->getId().', have '.$header['id']);
      }
      
      $return= new peer·net·Message($header['id']);
      
      // ???
      //for ($i= 0; $i < $header['qdcount']; $i++) {
      //  $c= 1;
      //  while ($c != 0) {
      //    $c= hexdec(bin2hex($this->sock->readBinary(1)));
      //  }
      //  $this->sock->readBinary(4);
      //}
      
      // 
      for ($i= 0; $i < $header['ancount']; $i++) {
        
        // Read domain labels
        $labels= array();
        $l= 1;
        while ($l > 0) {
          $l= ord($this->sock->readBinary(1));
          if ($l <= 0) break;
          $labels[]= $this->sock->readBinary($l);
        }
        Console::writeLine(new Bytes($this->sock->readBinary(6)));   // WTF?
        
        $r= unpack('ntype/nclass/Nttl/nlength', $this->sock->readBinary(10));
        Console::writeLine('RECORD ', $r);
        switch ($r['type']) {
          case 1:   // A
            // $record= new ARecord();
            $record= array(
              'domain' => implode('.', $labels),
              'ip'     => implode('.', unpack('Ca/Cb/Cc/Cd', $this->sock->readBinary(4)))
            );
            break;
          
          default:
            throw new ProtocolException('Unknown record type '.$r['type']);
        }
        $return->addRecord($record);
      }
      

      return $return;
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
  
