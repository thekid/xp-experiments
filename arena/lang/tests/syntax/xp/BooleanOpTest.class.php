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
  class BooleanOpTest extends ParserTestCase {
  
    /**
     * Test boolean "or" operator (||)
     *
     */
    #[@test]
    public function booleanOr() {
      $this->assertEquals(array(new BooleanOpNode(array(
        'position'      => array(4, 17),
        'lhs'           => $this->create(new VariableNode('$a'), array(4, 9)),
        'rhs'           => $this->create(new VariableNode('$b'), array(4, 15)),
        'op'            => '||'
      ))), $this->parse('
        $a || $b;
      '));
    }

    /**
     * Test boolean "and" operator (&&)
     *
     */
    #[@test]
    public function booleanAnd() {
      $this->assertEquals(array(new BooleanOpNode(array(
        'position'      => array(4, 17),
        'lhs'           => $this->create(new VariableNode('$a'), array(4, 9)),
        'rhs'           => $this->create(new VariableNode('$b'), array(4, 15)),
        'op'            => '&&'
      ))), $this->parse('
        $a && $b;
      '));
    }
  }
?>
