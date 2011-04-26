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
     * @param   
     */
    public function __construct($name, $type= 1) {
      $this->name= $name;
      $this->type= $type;
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
      
      $message= new peer·net·Message();
      $message->setType($this->type);
      $message->setFlags(0x0100 & 0x0300);  // recursion & queryspecmask
      
      //XXX RECORD XXX
      $message->addRecord($this->name);   

      return $this->resolver->send($message);
    }
  }
?>
