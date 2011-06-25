<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.Resolvers', 
    'peer.net.QType', 
    'peer.net.Query',
    'peer.net.Response'
  );

  /**
   * DNS lookup
   *
   * Usage examples
   * ==============
   * Most simple usage:
   * <code>
   *   $l= new DnsLookup('xp-framework.net');
   *   $records= $l->run();
   * </code>
   *
   * Using the system resolvers instead of the default:
   * <code>
   *   $l= new DnsLookup('xp-framework.net');
   *   $l->setResolver(Resolvers::systemResolver());
   *   $records= $l->run();
   * </code>
   *
   * @test  xp://net.xp_framework.unittest.peer.net.DnsLookupTest
   * @see   xp://peer.net.Resolvers
   * @see   http://www.lavantech.com/dnscomponent/javadoc/com/lavantech/net/dns/DNSLookup.html
   * @see   http://www.xbill.org/dnsjava/
   * @see   http://www.netfor2.com/dns.htm
   */
  class DnsLookup extends Object {
    protected $name= '';
    protected $type= NULL;
    protected $resolver= NULL;
  
    /**
     * Create a new lookup
     *
     * @param   string name
     * @param   peer.net.QType type default NULL if omitted, ANY
     */
    public function __construct($name, QType $type= NULL) {
      $this->name= $name;
      $this->type= NULL === $type ? QType::$ANY : $type;
    }
  
    /**
     * Set resolver to use
     *
     * @param   peer.net.Resolver resolver
     */
    public function setResolver(peer搖et愛esolver $resolver) {
      $this->resolver= $resolver;
    }

    /**
     * Set resolver to use
     *
     * @param   peer.net.Resolver resolver
     * @return  peer.net.DnsLookup this
     */
    public function withResolver(peer搖et愛esolver $resolver) {
      $this->resolver= $resolver;
      return $this;
    }
    
    /**
     * Gets resolver in use
     *
     * @param   peer.net.Resolver resolver
     * @return  peer.net.Resolver 
     */
    public function getResolver() {
      if (NULL === $this->resolver) {
        $this->resolver= Resolvers::defaultResolver();
      }
      return $this->resolver;
    }
    
    /**
     * Runs this lookup
     *
     * @return  peer.net.Response
     * @throws  peer.net.ResolveException
     */
    public function run() {
      $request= new peer搖et愚essage();
      $request->setFlags(0x0100 & 0x0300);  // recursion & queryspecmask
      $request->addRecord(new peer搖et想uery($this->name, $this->type, 1));

      try {
        $response= $this->getResolver()->send($request);
      } catch (ResolveException $e) {
        throw $e;
      } catch (Throwable $t) {
        throw new ResolveException($t->getMessage(), $t);
      }
      
      return new peer搖et愛esponse($response->getRcode(), $response->getRecords());
    }
  }
?>
