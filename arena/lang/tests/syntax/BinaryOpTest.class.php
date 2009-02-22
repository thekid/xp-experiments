<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.syntax.ParserTestCase');

  /**
   * TestCase
   *
   */
  class BinaryOpTest extends ParserTestCase {
  
    /**
     * Test addition operator
     *
     */
    #[@test]
    public function addition() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '+'
      ))), $this->parse('
        $i + 10;
      '));
    }

    /**
     * Test subtraction operator
     *
     */
    #[@test]
    public function subtraction() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '-'
      ))), $this->parse('
        $i - 10;
      '));
    }

    /**
     * Test multiplication operator
     *
     */
    #[@test]
    public function multiplication() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '*'
      ))), $this->parse('
        $i * 10;
      '));
    }

    /**
     * Test division operator
     *
     */
    #[@test]
    public function division() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '/'
      ))), $this->parse('
        $i / 10;
      '));

    }

    /**
     * Test modulo operator
     *
     */
    #[@test]
    public function modulo() {
      $this->assertEquals(array(new BinaryOpNode(array(
        'position'      => array(4, 18),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '%'
      ))), $this->parse('
        $i % 10;
      '));
    }
  }
?>
