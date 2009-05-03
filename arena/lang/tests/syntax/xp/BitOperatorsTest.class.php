<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.syntax.xp.ParserTestCase');

  /**
   * TestCase
   *
   * @see   php://language.operators.bitwise
   */
  class BitOperatorsTest extends ParserTestCase {
  
    /**
     * Test "|" operator
     *
     */
    #[@test]
    public function bitwiseOr() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 14),
        'lhs'           => new IntegerNode(array('position' => array(4, 9), 'value' => '1')),
        'rhs'           => new IntegerNode(array('position' => array(4, 13), 'value' => '2')),
        'op'            => '|'
      ))), $this->parse('
        1 | 2;
      '));
    }

    /**
     * Test "&" operator
     *
     */
    #[@test]
    public function bitwiseAnd() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 14),
        'lhs'           => new IntegerNode(array('position' => array(4, 9), 'value' => '1')),
        'rhs'           => new IntegerNode(array('position' => array(4, 13), 'value' => '2')),
        'op'            => '&'
      ))), $this->parse('
        1 & 2;
      '));
    }

    /**
     * Test "^" operator
     *
     */
    #[@test]
    public function bitwiseXOr() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 14),
        'lhs'           => new IntegerNode(array('position' => array(4, 9), 'value' => '1')),
        'rhs'           => new IntegerNode(array('position' => array(4, 13), 'value' => '2')),
        'op'            => '^'
      ))), $this->parse('
        1 ^ 2;
      '));
    }

    /**
     * Test "~" prefix operator
     *
     */
    #[@test]
    public function bitwiseNot() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 11),
        'expression'    => new IntegerNode(array('position' => array(4, 10), 'value' => '1')),
        'postfix'       => FALSE,
        'op'            => '~'
      ))), $this->parse('
        ~1;
      '));
    }

    /**
     * Test "<<" operator
     *
     */
    #[@test]
    public function shiftLeft() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 15),
        'lhs'           => new IntegerNode(array('position' => array(4, 9), 'value' => '1')),
        'rhs'           => new IntegerNode(array('position' => array(4, 14), 'value' => '2')),
        'op'            => '<<'
      ))), $this->parse('
        1 << 2;
      '));
    }

    /**
     * Test ">>" operator
     *
     */
    #[@test]
    public function shiftRight() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 15),
        'lhs'           => new IntegerNode(array('position' => array(4, 9), 'value' => '1')),
        'rhs'           => new IntegerNode(array('position' => array(4, 14), 'value' => '2')),
        'op'            => '>>'
      ))), $this->parse('
        1 >> 2;
      '));
    }
  }
?>
