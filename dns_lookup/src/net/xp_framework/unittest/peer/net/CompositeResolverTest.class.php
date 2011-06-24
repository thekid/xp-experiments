<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.ConnectException',
    'peer.net.Resolver',
    'peer.net.ARecord',
    'peer.net.CompositeResolver',
    'net.xp_framework.unittest.peer.net.FakeResolver'
  );

  /**
   * TestCase
   *
   * @see      xp://peer.net.CompositeResolver
   */
  class CompositeResolverTest extends TestCase {
    protected $fixture, $message, $record;
    
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new CompositeResolver();
      $this->message= new peer·net·Message();
      $this->record= new ARecord('example.com', '192.0.43.10');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function delegatesInitiallyEmpty() {
      $this->assertFalse($this->fixture->hasDelegates());
    }

    /**
     * Test addDelegate() 
     *
     */
    #[@test]
    public function addDelegate() {
      $this->fixture->addDelegate(new FakeResolver());
      $this->assertTrue($this->fixture->hasDelegates());
    }

    /**
     * Test withDelegate()
     *
     */
    #[@test]
    public function withDelegate() {
      $this->fixture->withDelegate(new FakeResolver());
      $this->assertTrue($this->fixture->hasDelegates());
    }

    /**
     * Test getDelegates()
     *
     */
    #[@test]
    public function getDelegates() {
      $delegates= array(new FakeResolver(), new FakeResolver());
      foreach ($delegates as $resolver) {
        $this->fixture->addDelegate($resolver);
      }
      $this->assertEquals($delegates, $this->fixture->getDelegates());
    }
    
    /**
     * Test
     *
     */
    #[@test, @expect(class= 'lang.IllegalStateException', withMessage= 'No resolvers to query')]
    public function emptyResolvers() {
      $this->fixture->send($this->message);
    }
 
    /**
     * Test
     *
     */
    #[@test]
    public function onlyResolverSucceeds() {
      $this->fixture->addDelegate(create(new FakeResolver())->returning(array($this->record)));
      $this->assertEquals(array($this->record), $this->fixture->send($this->message));
    }

    /**
     * Test
     *
     */
    #[@test, @expect(class= 'peer.ConnectException', withMessage= 'Cannot connect')]
    public function onlyResolverFails() {
      $this->fixture->addDelegate(create(new FakeResolver())->throwing(new ConnectException('Cannot connect')));
      $this->fixture->send($this->message);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function firstResolverFails() {
      $this->fixture->addDelegate(create(new FakeResolver())->throwing(new ConnectException('Cannot connect')));
      $this->fixture->addDelegate(create(new FakeResolver())->returning(array($this->record)));
      $this->assertEquals(array($this->record), $this->fixture->send($this->message));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function secondResolverFails() {
      $this->fixture->addDelegate(create(new FakeResolver())->returning(array($this->record)));
      $this->fixture->addDelegate(create(new FakeResolver())->throwing(new Error('Unreachable code!')));
      $this->assertEquals(array($this->record), $this->fixture->send($this->message));
    }
  }
?>
