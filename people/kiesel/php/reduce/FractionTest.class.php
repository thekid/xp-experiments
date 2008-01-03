<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'Fraction'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class FractionTest extends TestCase {
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
    }
    
    #[@test, @expect('lang.IllegalArgumentException')]
    public function nonZeroDenominator() {
      new Fraction(1, 0);
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function integerDetection() {
      $this->assertTrue(create(new Fraction(5, 1))->isInteger());
      $this->assertTrue(create(new Fraction(4, 2))->isInteger());
    }
    
    #[@test]
    public function floatDetection() {
      $this->assertFalse(create(new Fraction(1, 2))->isInteger());
    }
    
    #[@test]
    public function getMethods() {
      $this->assertEquals(4, create(new Fraction(4, 5))->getNumerator());
      $this->assertEquals(5, create(new Fraction(4, 5))->getDenominator());
    }
    
    #[@test]
    public function fractionEquals() {
      $this->assertEquals(
        new Fraction(1, 2),
        new Fraction(1, 2)
      );
    }
    
    #[@test]
    public function sameValueFractionNotEqual() {
      $this->assertNotEquals(
        new Fraction(1, 2),
        new Fraction(2, 4)
      );
    }
    
    #[@test]
    public function differentValueNotEquals() {
      $this->assertNotEquals(
        new Fraction(1, 1),
        new Fraction(1, 2)
      );
    }
    
    protected function reduce($n, $d) {
      return create(new Fraction($n, $d))->reduce();
    }
    
    #[@test]
    public function noopReduce() {
      $this->assertEquals(new Fraction(1, 1), $this->reduce(1, 1));
    }
    
    #[@test]
    public function remainderlessReduce() {
      $this->assertEquals(new Fraction(1, 1), $this->reduce(2, 2));
    }
    
    #[@test]
    public function linearReduce() {
      $this->assertEquals(new Fraction(1, 2), $this->reduce(2, 4));
    }
    
    #[@test]
    public function linearReduceWithOddNumbers() {
      $this->assertEquals(new Fraction(1, 3), $this->reduce(99, 99*3));
    }
    
    #[@test]
    public function noReduction() {
      $this->assertEquals(new Fraction(13, 17), $this->reduce(13, 17));
    }
    
    #[@test]
    public function reduceNegative() {
      $this->assertEquals(new Fraction(2, -2), $this->reduce(2, -4));
    }
  }
?>
