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
  class ComparisonTest extends ParserTestCase {
  
    /**
     * Test equality comparison
     *
     */
    #[@test]
    public function equality() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 17),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '=='
      ))), $this->parse('
        $i == 10;
      '));
    }

    /**
     * Test unequality comparison
     *
     */
    #[@test]
    public function unEquality() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 17),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '!='
      ))), $this->parse('
        $i != 10;
      '));
    }

    /**
     * Test smaller than comparison
     *
     */
    #[@test]
    public function smallerThan() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 16),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '<'
      ))), $this->parse('
        $i < 10;
      '));
    }

    /**
     * Test smaller than or equal to comparison
     *
     */
    #[@test]
    public function smallerThanOrEqualTo() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 17),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '<='
      ))), $this->parse('
        $i <= 10;
      '));
    }

    /**
     * Test greater than comparison
     *
     */
    #[@test]
    public function greaterThan() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 16),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 16), 'value' => '10')),
        'op'            => '>'
      ))), $this->parse('
        $i > 10;
      '));
    }

    /**
     * Test greather than or equal to comparison
     *
     */
    #[@test]
    public function greaterThanOrEqualTo() {
      $this->assertEquals(array(new ComparisonNode(array(
        'position'      => array(4, 17),
        'lhs'           => $this->create(new VariableNode('$i'), array(4, 11)),
        'rhs'           => new NumberNode(array('position' => array(4, 17), 'value' => '10')),
        'op'            => '>='
      ))), $this->parse('
        $i >= 10;
      '));
    }
  }
?>
