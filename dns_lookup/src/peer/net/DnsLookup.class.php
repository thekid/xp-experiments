<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Resolvers');

  /**
   * (Insert class' description here)
   *
   * @see     http://www.netfor2.com/dns.htm
   */
  class DnsLookup extends Object {
    protected $name= '';
    protected $resolver= NULL;
  
    /**
     * (Insert method's description here)
     *
     * @param   
     */
    public function __construct($name) {
      $this->name= $name;
    }
  
    /**
     * (Insert method's description here)
     *
     * @param   
     */
    public function setResolver(peer·net·Resolver $resolver) {
      $this->resolver= $resolver;
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  
     */
    public function run() {
      if (NULL === $this->resolver) {
        $this->resolver= Resolvers::systemResolver();
      }
      Console::writeLine(new Bytes($this->resolver->send(new peer·net·Message($name))));
    }
  }
?>
