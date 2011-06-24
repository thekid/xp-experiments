<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Resolvers');

  /**
   * A DNS lookup
   *
   * <code>
   *   $l= new DnsLookup('xp-framework.net');
   *   $records= $l->run();
   * </code>
   *
   * @see     php://dns_get_record
   * @see     http://www.lavantech.com/dnscomponent/javadoc/com/lavantech/net/dns/DNSLookup.html
   * @see     http://www.netfor2.com/dns.htm
   */
  class DnsLookup extends Object {
    protected $name= '';
    protected $resolver= NULL;
  
    /**
     * Create a new lookup
     *
     * @param   string name
     * @param   int type
     */
    public function __construct($name, $type= 1) {
      $this->name= $name;
      $this->type= $type;
    }
  
    /**
     * Set resolver to use
     *
     * @param   peer.net.Resolver resolver
     */
    public function setResolver(peer·net·Resolver $resolver) {
      $this->resolver= $resolver;
    }
    
    /**
     * Runs this lookup
     *
     * @return  peer.net.Record[]
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
