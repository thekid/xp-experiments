<?php
/* This class is part of the XP framework
 *
 * $Id$
 */


  uses('unittest.mock.Expectation');

  /**
 * Test cases for
 */
  class ExpectationTest extends TestCase {

    private $sut = null;

    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
        $this->sut = new Expectation();
    }


    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
        new Expectation();
    }

    /**
     * By default the return value is null
     */
    #[@test]
    public function returnValue_isNull_byDefault() {
      $this->assertNull($this->sut->getReturn());
    }
    
    /**
     * The return value can be set
     */
    #[@test]
    public function returnValue_canSetGet() {
      $this->sut->setReturn("foo");
      $this->assertEquals("foo", $this->sut->getReturn());
    }
    
    /**
     * The repeat count is 0 by default
     */
    #[@test]
    public function repeat_is0_byDefault() {
      $this->assertEquals(0, $this->sut->getRepeat());
    }

    /**
     * The repeat count can be set
     */
    #[@test]
    public function repeat_canSetGet() {
      $this->sut->setRepeat(5);
      $this->assertEquals(5, $this->sut->getRepeat());
    }

    /**
     * The actual call count is 0 by default
     */
    #[@test]
    public function actualCalls_is0_byDefault() {
      $this->assertEquals(0, $this->sut->getActualCalls());
    }

    /**
     * The repeat count can be set
     */
    #[@test]
    public function incActualCalls_increasesBy1() {
      $this->sut->incActualCalls();
      $this->assertEquals(1, $this->sut->getActualCalls());
    }

    /**
     * CanRepeat is true by default
     */
    #[@test]
    public function canRepeat_isTrueOnce_ByDefault() {
      $this->assertTrue($this->sut->canRepeat());
      $this->sut->incActualCalls();
      $this->assertFalse($this->sut->canRepeat());
      
    }
    /**
     * CanRepeat should be true if repeat is set to -1,
     * even after incActualCalls
     */
    #[@test]
    public function canRepeat_isTrue_withRepeatMinus1() {
      $this->sut->setRepeat(-1);

      $this->assertTrue($this->sut->canRepeat());
      $this->sut->incActualCalls();
      $this->assertTrue($this->sut->canRepeat());
      $this->sut->incActualCalls();
      $this->assertTrue($this->sut->canRepeat());
      $this->sut->incActualCalls();
      $this->assertTrue($this->sut->canRepeat());
      $this->sut->incActualCalls();
    }

    /**
     * CanRepeat with repeat==1 returns 2 times true and then false
     */
    #[@test]
    public function canRepeat_withNumericRepeat1_TrueTwice() {
      $this->sut->setRepeat(1);
      $this->assertTrue($this->sut->canRepeat());
      $this->sut->incActualCalls();
      $this->assertTrue($this->sut->canRepeat());
      $this->sut->incActualCalls();
      $this->assertFalse($this->sut->canRepeat());
    }
  }
?>