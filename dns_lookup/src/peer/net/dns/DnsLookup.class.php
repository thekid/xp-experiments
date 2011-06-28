<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.net.dns.Resolvers', 
    'peer.net.dns.QType', 
    'peer.net.dns.Question',
    'peer.net.dns.Response'
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
   * Using "dns.corporation.org" as DNS server
   * <code>
   *   $l= new DnsLookup('xp-framework.net');
   *   $l->setResolver(new DnsResolver('dns.corporation.org')));
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
    protected $resolver= NULL;
    protected $question= NULL;
  
    /**
     * Create a new lookup
     *
     * @param   string name
     * @param   peer.net.dns.QType type default NULL if omitted, ANY
     * @param   peer.net.dns.QClass qclass default NULL if omitted, IN
     */
    public function __construct($name, QType $type= NULL, QClass $class= NULL) {
      $this->question= new Question($name, $type, $class);
    }
  
    /**
     * Set resolver to use
     *
     * @param   peer.net.dns.Resolver resolver
     */
    public function setResolver(peer·net·dns·Resolver $resolver) {
      $this->resolver= $resolver;
    }

    /**
     * Set resolver to use
     *
     * @param   peer.net.dns.Resolver resolver
     * @return  peer.net.dns.DnsLookup this
     */
    public function withResolver(peer·net·dns·Resolver $resolver) {
      $this->resolver= $resolver;
      return $this;
    }
    
    /**
     * Gets resolver in use
     *
     * @param   peer.net.dns.Resolver resolver
     * @return  peer.net.dns.Resolver 
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
     * @return  peer.net.dns.Response
     * @throws  peer.net.dns.ResolveException
     */
    public function run() {
      try {
        $result= $this->getResolver()->send($this->question);
      } catch (ResolveException $e) {
        throw $e;
      } catch (Throwable $t) {
        throw new ResolveException($t->getMessage(), $t);
      }
      
      return new peer·net·dns·Response($result->getRcode(), $result->allRecords());
    }
  }
?>
