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
        'position'      => array(4, 19),
        'condition'     => $this->create(new VariableNode('i'), array(4, 9)),
        'expression'    => new NumberNode(array('position' => array(4, 14), 'value' => '1')),
        'conditional'   => new NumberNode(array('position' => array(4, 18), 'value' => '2')),
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
        'position'      => array(4, 31),
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => new TernaryNode(array(
          'position'      => array(4, 31),
          'condition'     => $this->create(new VariableNode('argc'), array(4, 13)),
          'expression'    => $this->create(new VariableNode('args0'), array(4, 21)),
          'conditional'   => new NumberNode(array('position' => array(4, 30), 'value' => '1'))
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
        'position'      => array(4, 16),
        'condition'     => $this->create(new VariableNode('i'), array(4, 9)),
        'expression'    => NULL,
        'conditional'   => new NumberNode(array('position' => array(4, 15), 'value' => '2')),
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
        'position'      => array(4, 27),
        'condition'     => $this->create(new VariableNode('i'), array(4, 9)),
        'expression'    => NULL,
        'conditional'   => new TernaryNode(array(
          'position'      => array(4, 26),
          'condition'     => $this->create(new VariableNode('f'), array(4, 16)),
          'expression'    => new NumberNode(array('position' => array(4, 21), 'value' => '1')),
          'conditional'   => new NumberNode(array('position' => array(4, 25), 'value' => '2')),
        ))
      ))), $this->parse('
        $i ?: ($f ? 1 : 2);
      '));
    }
  }
?>
