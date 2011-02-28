<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('unittest.mock.ReplayState');

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
    #[@test, @ignore]
    public function handleInvocation_withExistingExpectation_returnExpectationsReturnValue() {
      $myExpectation=new Expectation();
      $myExpectation->setReturn('foobar');
      
      $expectationsList=new ExpectationList();
      $expectationsList->add($myExpectation);
      
      $this->expectationMap->put('foo', $expectationsList);
      
      $this->assertEquals($myExpectation->getReturn(), $this->sut->handleInvocation('foo', null));
    }

  }
?>
