<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.mock.ExpectationList',
       'unittest.mock.Expectation');
  
/**
 * Test cases for the ExpectationList class
 *
 * @purpose Unit tests
 */
  class ExpectationListTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new ExpectationList();
    }
      
    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new ExpectationList();
    }

    /**
     * getNext should exist.          
     */
    #[@test]
    public function canCallGetNext() {
      $this->sut->getNext();
    }
    
    /**
     * getNext should return null after initialization.                  
     */
    #[@test]
    public function getNext_returnNullByDefault() {
      $this->assertNull($this->sut->getNext());
    }
    
    /**
     * add method should exist.            
     */
    #[@test]
    public function canAddExpectation() {
      $this->sut->add(new Expectation());
    }
    
    /**
     * Added expectations should be returned by getNext.
     */
    #[@test]
    public function getNextReturnsAddedExpectation() {
      $expect=new Expectation();
      $this->sut->add($expect);
      
      $this->assertEquals($expect, $this->sut->getNext());
    }
    
    /**
     * If no more expectations left, getNext should return null.
     */
    #[@test]
    public function getNextReturnsNullIfNoMoreElements() {
      $expect=new Expectation();
      $this->sut->add($expect);
      
      $this->assertEquals($expect, $this->sut->getNext());
      $this->assertNull($this->sut->getNext());
    }
    
    /**
     * Null shall never be added.
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function cannotAddNull() {
      $this->sut->add(null);
    }
    
    /**
     * Another object shall never be added.
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function cannotAddObjects() {
      $this->sut->add(new Object());
    }
  }

?>