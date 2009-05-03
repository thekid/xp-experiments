<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.optimize.Optimizations',
    'xp.compiler.optimize.BinaryOptimization',
    'xp.compiler.ast.IntegerNode',
    'xp.compiler.ast.DecimalNode',
    'xp.compiler.ast.StringNode'
  );

  /**
   * TestCase for binary operations
   *
   * @see      xp://xp.compiler.optimize.BinaryOptimization
   */
  class BinaryOptimizationTest extends TestCase {
    protected $fixture = NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new Optimizations();
      $this->fixture->add(XPClass::forName('xp.compiler.ast.BinaryOpNode'), new BinaryOptimization());
    }
    
    /**
     * Test adding integers
     *
     */
    #[@test]
    public function addIntegers() {
      $this->assertEquals(new IntegerNode(array('value' => 1)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 1)), 
        'rhs' => new IntegerNode(array('value' => 0)), 
        'op'  => '+'
      ))));
    }

    /**
     * Test subtracting integers
     *
     */
    #[@test]
    public function subtractIntegers() {
      $this->assertEquals(new IntegerNode(array('value' => -1)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 1)), 
        'rhs' => new IntegerNode(array('value' => 2)), 
        'op'  => '-'
      ))));
    }

    /**
     * Test multiplying integers
     *
     */
    #[@test]
    public function multiplyIntegers() {
      $this->assertEquals(new IntegerNode(array('value' => 2)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 1)), 
        'rhs' => new IntegerNode(array('value' => 2)), 
        'op'  => '*'
      ))));
    }

    /**
     * Test dividing integers
     *
     */
    #[@test]
    public function divideIntegers() {
      $this->assertEquals(new DecimalNode(array('value' => 2)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 4)), 
        'rhs' => new IntegerNode(array('value' => 2)), 
        'op'  => '/'
      ))));
    }

    /**
     * Test modulo division on integers
     *
     */
    #[@test]
    public function modIntegers() {
      $this->assertEquals(new IntegerNode(array('value' => 1)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 4)), 
        'rhs' => new IntegerNode(array('value' => 3)), 
        'op'  => '%'
      ))));
    }

    /**
     * Test shift right on integers
     *
     */
    #[@test]
    public function shrIntegers() {
      $this->assertEquals(new IntegerNode(array('value' => 2)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 4)), 
        'rhs' => new IntegerNode(array('value' => 1)), 
        'op'  => '>>'
      ))));
    }

    /**
     * Test shift left on integers
     *
     */
    #[@test]
    public function shlIntegers() {
      $this->assertEquals(new IntegerNode(array('value' => 32)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 4)), 
        'rhs' => new IntegerNode(array('value' => 3)), 
        'op'  => '<<'
      ))));
    }

    /**
     * Test adding decimals
     *
     */
    #[@test]
    public function addDecimals() {
      $this->assertEquals(new DecimalNode(array('value' => 1.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new DecimalNode(array('value' => 1.0)), 
        'rhs' => new DecimalNode(array('value' => 0.0)), 
        'op'  => '+'
      ))));
    }

    /**
     * Test subtracting decimals
     *
     */
    #[@test]
    public function subtractDecimals() {
      $this->assertEquals(new DecimalNode(array('value' => -1.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new DecimalNode(array('value' => 1.0)), 
        'rhs' => new DecimalNode(array('value' => 2.0)), 
        'op'  => '-'
      ))));
    }

    /**
     * Test multiplying decimals
     *
     */
    #[@test]
    public function multiplyDecimals() {
      $this->assertEquals(new DecimalNode(array('value' => 2.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new DecimalNode(array('value' => 1.0)), 
        'rhs' => new DecimalNode(array('value' => 2.0)), 
        'op'  => '*'
      ))));
    }

    /**
     * Test dividing decimals
     *
     */
    #[@test]
    public function divideDecimals() {
      $this->assertEquals(new DecimalNode(array('value' => 2.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new DecimalNode(array('value' => 4.0)), 
        'rhs' => new DecimalNode(array('value' => 2.0)), 
        'op'  => '/'
      ))));
    }

    /**
     * Test adding integers and decimals
     *
     */
    #[@test]
    public function addIntegerAndDecimal() {
      $this->assertEquals(new DecimalNode(array('value' => 1.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 1)), 
        'rhs' => new DecimalNode(array('value' => 0.0)), 
        'op'  => '+'
      ))));
    }

    /**
     * Test subtracting integers and decimals
     *
     */
    #[@test]
    public function subtractIntegerAndDecimal() {
      $this->assertEquals(new DecimalNode(array('value' => -1.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 1)), 
        'rhs' => new DecimalNode(array('value' => 2.0)), 
        'op'  => '-'
      ))));
    }

    /**
     * Test multiplying integers and decimals
     *
     */
    #[@test]
    public function multiplyIntegerAndDecimal() {
      $this->assertEquals(new DecimalNode(array('value' => 2.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 1)), 
        'rhs' => new DecimalNode(array('value' => 2.0)), 
        'op'  => '*'
      ))));
    }

    /**
     * Test dividing integers and decimals
     *
     */
    #[@test]
    public function divideIntegerAndDecimal() {
      $this->assertEquals(new DecimalNode(array('value' => 2.0)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 4)), 
        'rhs' => new DecimalNode(array('value' => 2.0)), 
        'op'  => '/'
      ))));
    }

    /**
     * Test adding strings
     *
     */
    #[@test]
    public function addStringsNotOptimized() {
      $o= new BinaryOpNode(array(
        'lhs' => new StringNode(array('value' => 'a')), 
        'rhs' => new StringNode(array('value' => 'b')), 
        'op'  => '+'
      ));
      $this->assertEquals($o, $this->fixture->optimize($o));
    }

    /**
     * Test subtracting strings
     *
     */
    #[@test]
    public function subtractStringsNotOptimized() {
      $o= new BinaryOpNode(array(
        'lhs' => new StringNode(array('value' => 'a')), 
        'rhs' => new StringNode(array('value' => 'b')), 
        'op'  => '-'
      ));
      $this->assertEquals($o, $this->fixture->optimize($o));
    }

    /**
     * Test multiplying strings
     *
     */
    #[@test]
    public function multiplyStringsNotOptimized() {
      $o= new BinaryOpNode(array(
        'lhs' => new StringNode(array('value' => 'a')), 
        'rhs' => new StringNode(array('value' => 'b')), 
        'op'  => '*'
      ));
      $this->assertEquals($o, $this->fixture->optimize($o));
    }

    /**
     * Test dividing strings
     *
     */
    #[@test]
    public function divideStringsNotOptimized() {
      $o= new BinaryOpNode(array(
        'lhs' => new StringNode(array('value' => 'a')), 
        'rhs' => new StringNode(array('value' => 'b')), 
        'op'  => '/'
      ));
      $this->assertEquals($o, $this->fixture->optimize($o));
    }

    /**
     * Test concatenating strings
     *
     */
    #[@test]
    public function concatenatingStrings() {
      $this->assertEquals(new StringNode(array('value' => 'Hello World')), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new StringNode(array('value' => 'Hello')), 
        'rhs' => new StringNode(array('value' => ' World')), 
        'op'  => '~'
      ))));
    }

    /**
     * Test optimizing a more complex binary operation (1 + 2 * 3)
     *
     */
    #[@test]
    public function optimizeComplex() {
      $this->assertEquals(new IntegerNode(array('value' => 7)), $this->fixture->optimize(new BinaryOpNode(array(
        'lhs' => new IntegerNode(array('value' => 1)), 
        'rhs' => new BinaryOpNode(array(
          'lhs' => new IntegerNode(array('value' => 2)), 
          'rhs' => new IntegerNode(array('value' => 3)), 
          'op'  => '*'
        )),
        'op'  => '+'
      ))));
    }
  }
?>
