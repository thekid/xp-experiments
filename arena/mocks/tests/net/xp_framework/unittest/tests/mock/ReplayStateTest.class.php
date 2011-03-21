<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('unittest.mock.ReplayState',
       'unittest.mock.Expectation',
       'unittest.mock.ExpectationList');

  /**
   * TODO: Description
   *
   * @see      xp://unittest.mock.Replay
   * @purpose  Unit Test
   */
  class ReplayStateTest extends TestCase {

    private 
      $sut=null,
      $expectationMap;
    
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->expectationMap= new Hashmap();
      $this->sut=new ReplayState($this->expectationMap);
    }
      
    /**
     * Cannot create without valid Hasmap.
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function expectationMapRequiredOnCreate() {
      new ReplayState(null);
    }
    
    /**
     * Can create with valid hasmap.
     */
    #[@test]
    public function canCreate() {
      new ReplayState(new Hashmap());
    }
    
    /**
     * Can call handle invocation.
     */
    #[@test]
    public function canHandleInvocation() {
      $this->sut->handleInvocation(null, null);
    }
    
    /**
     * if expectation exists, return value is returned                        
     */
    #[@test]
    public function handleInvocation_withExistingExpectation_returnExpectationsReturnValue() {
      $myExpectation=new Expectation();
      $myExpectation->setReturn('foobar');
      
      $expectationsList=new ExpectationList();
      $expectationsList->add($myExpectation);
      
      $this->expectationMap->put('foo', $expectationsList);
      
      $this->assertEquals($myExpectation->getReturn(), $this->sut->handleInvocation('foo', null));
    }
    /**
     * if no expectations are left, null is returned                       
     */
    #[@test]
    public function handleInvocation_missingExpectation_returnsNull() {
      $myExpectation=new Expectation();
      $myExpectation->setReturn('foobar');
      
      $expectationsList=new ExpectationList();
      $expectationsList->add($myExpectation);
      
      $this->expectationMap->put('foo', $expectationsList);
      
      $this->assertEquals($myExpectation->getReturn(), $this->sut->handleInvocation('foo', null));
      $this->assertNull($this->sut->handleInvocation('foo', null));
    }

    /**
     * 
     */
    #[@test]
    public function handleInvocation_ExpectationRepeatedOnce_returnExpectationsReturnValueTwice() {
      $myExpectation=new Expectation();
      $myExpectation->setReturn('foobar');
      $myExpectation->setRepeat(1);

      $expectationsList=new ExpectationList();
      $expectationsList->add($myExpectation);

      $this->expectationMap->put('foo', $expectationsList);

      $this->assertEquals($myExpectation->getReturn(), $this->sut->handleInvocation('foo', null));
      $this->assertEquals($myExpectation->getReturn(), $this->sut->handleInvocation('foo', null));
      $this->assertNull($this->sut->handleInvocation('foo', null));
    }
  }
?>
