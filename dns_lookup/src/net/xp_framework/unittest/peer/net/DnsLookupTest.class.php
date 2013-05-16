<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.ConnectException',
    'peer.net.dns.DnsLookup',
    'peer.net.dns.ARecord',
    'net.xp_framework.unittest.peer.net.FakeResolver'
  );

  /**
   * TestCase
   *
   * @see      xp://peer.net.dns.DnsLookup
   */
  class DnsLookupTest extends TestCase {
    protected $fixture, $record;
    
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new DnsLookup('example.com');
      $this->record= new ARecord('example.com', 0, '192.0.43.10');
    }

    /**
     * Test getResolver()
     *
     */
    #[@test]
    public function defaultResolverUsedIfNoResolverSpecified() {
      $this->assertEquals(Resolvers::defaultResolver(), $this->fixture->getResolver());
    }

    /**
     * Test setResolver()
     *
     */
    #[@test]
    public function setResolver() {
      with ($resolver= new FakeResolver()); {
        $this->fixture->setResolver($resolver);
        $this->assertEquals($resolver, $this->fixture->getResolver());
      }
    }

    /**
     * Test withResolver()
     *
     */
    #[@test]
    public function withResolver() {
      with ($resolver= new FakeResolver()); {
        $this->fixture->withResolver($resolver);
        $this->assertEquals($resolver, $this->fixture->getResolver());
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function succedingResolver() {
      $this->fixture->setResolver(create(new FakeResolver())->returning(array($this->record)));
      $this->assertEquals(array($this->record), $this->fixture->run()->answers());
    }

    /**
     * Test
     *
     */
    #[@test, @expect(class= 'peer.net.dns.ResolveException', withMessage= 'Cannot connect')]
    public function failingResolver() {
      $this->fixture->setResolver(create(new FakeResolver())->throwing(new ConnectException('Cannot connect')));
      $this->fixture->run();
    }
  }
?>
