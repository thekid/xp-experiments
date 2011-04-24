<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Resolver', 'peer.net.Message', 'peer.UDPSocket');

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
      $this->sock->write($query->getBytes());
      return $this->sock->readBinary();
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
