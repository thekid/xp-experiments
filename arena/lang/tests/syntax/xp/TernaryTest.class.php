<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.syntax.xp.ParserTestCase');

  /**
   * TestCase
   *
   */
  class TernaryTest extends ParserTestCase {
  
    /**
     * Test ternary - expr ? expr : expr
     *
     */
    #[@test]
    public function ternary() {
      $this->assertEquals(array(new TernaryNode(array(
        'position'      => array(4, 21),
        'condition'     => $this->create(new VariableNode('$i'), array(4, 11)),
        'expression'    => new NumberNode(array('position' => array(4, 16), 'value' => '1')),
        'conditional'   => new NumberNode(array('position' => array(4, 20), 'value' => '2')),
      ))), $this->parse('
        $i ? 1 : 2;
      '));
    }

    /**
     * Test ternary - expr ?: expr
     *
     */
    #[@test]
    public function assignment() {
      $this->assertEquals(array(new AssignmentNode(array(
        'position'      => array(4, 33),
        'variable'      => $this->create(new VariableNode('$a'), array(4, 11)),
        'expression'    => new TernaryNode(array(
          'position'      => array(4, 33),
          'condition'     => $this->create(new VariableNode('$argc'), array(4, 15)),
          'expression'    => $this->create(new VariableNode('$args0'), array(4, 23)),
          'conditional'   => new NumberNode(array('position' => array(4, 32), 'value' => '1'))
        )),
        'op'            => '='
      ))), $this->parse('
        $a= $argc ? $args0 : 1;
      '));
    }

    /**
     * Test ternary - expr ?: expr
     *
     */
    #[@test]
    public function withoutExpression() {
      $this->assertEquals(array(new TernaryNode(array(
        'position'      => array(4, 18),
        'condition'     => $this->create(new VariableNode('$i'), array(4, 11)),
        'expression'    => NULL,
        'conditional'   => new NumberNode(array('position' => array(4, 17), 'value' => '2')),
      ))), $this->parse('
        $i ?: 2;
      '));
    }

    /**
     * Test ternary - expr ?: (expr ? expr : expr)
     *
     */
    #[@test]
    public function nested() {
      $this->assertEquals(array(new TernaryNode(array(
        'position'      => array(4, 29),
        'condition'     => $this->create(new VariableNode('$i'), array(4, 11)),
        'expression'    => NULL,
        'conditional'   => new TernaryNode(array(
          'position'      => array(4, 28),
          'condition'     => $this->create(new VariableNode('$f'), array(4, 18)),
          'expression'    => new NumberNode(array('position' => array(4, 23), 'value' => '1')),
          'conditional'   => new NumberNode(array('position' => array(4, 27), 'value' => '2')),
        ))
      ))), $this->parse('
        $i ?: ($f ? 1 : 2);
      '));
    }
  }
?>
