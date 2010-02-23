<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'net.xp_framework.unittest.core.overloading.TypeDispatchFixture',
    'util.Date'
  );

  /**
   * TestCase
   *
   * @see      xp://net.xp_framework.unittest.core.overloading.TypeDispatchFixture
   */
  class RuntimeDispatchingTest extends TestCase {
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new TypeDispatchFixture();
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function stringVariant() {
      $this->assertEquals('s:5@iso-8859-1:Hello;', $this->fixture->serialize('Hello'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function stringVariantWithOptionalArg() {
      $this->assertEquals('s:5@utf-8:Hello;', $this->fixture->serialize('Hello', 'utf-8'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function intVariant() {
      $this->assertEquals('i:5;', $this->fixture->serialize(5));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function objectVariant() {
      $this->assertEquals('O:lang.Object;', $this->fixture->serialize(new Object()));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function testVariant() {
      $this->assertEquals('O:net.xp_framework.unittest.core.overloading.RuntimeDispatchingTest;', $this->fixture->serialize($this));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function dateVariant() {
      $this->assertEquals('T:250944900;', $this->fixture->serialize(new Date('1977-12-14 11:55:00')));
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.MethodNotImplementedException')]
    public function doubleVariant() {
      $this->fixture->serialize(1.0);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.MethodNotImplementedException')]
    public function twoArgsVariant() {
      $this->fixture->serialize(5, TRUE);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.MethodNotImplementedException')]
    public function noArgsVariant() {
      $this->fixture->serialize();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function nullVariant() {
      $this->assertEquals('N;', $this->fixture->serialize(NULL));
    }
  }
?>
