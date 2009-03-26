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
  class LoopTest extends ParserTestCase {
  
    /**
     * Test for loop
     *
     */
    #[@test]
    public function forLoop() {
      $this->assertEquals(array(new ForNode(array(
        'position'       => array(4, 9),
        'initialization' => array(new AssignmentNode(array(
          'position'       => array(4, 19),
          'variable'       => $this->create(new VariableNode('i'), array(4, 14)),
          'expression'     => new NumberNode(array('position' => array(4, 18), 'value' => '0')),
          'op'             => '='
        ))),
        'condition'      => array(new ComparisonNode(array(
          'position'      => array(4, 26),
          'lhs'           => $this->create(new VariableNode('i'), array(4, 21)),
          'rhs'           => new NumberNode(array('position' => array(4, 26), 'value' => '1000')),
          'op'            => '<'
        ))),
        'loop'           => array(new UnaryOpNode(array(
          'position'      => array(4, 34),
          'expression'    => $this->create(new VariableNode('i'), array(4, 32)),
          'op'            => '++',
          'postfix'       => TRUE
        ))),
        'statements'     => NULL, 
      ))), $this->parse('
        for ($i= 0; $i < 1000; $i++) { }
      '));
    }

    /**
     * Test foreach loop
     *
     */
    #[@test]
    public function foreachLoop() {
      $this->assertEquals(array(new ForeachNode(array(
        'position'      => array(4, 9),
        'expression'    => $this->create(new VariableNode('list'), array(4, 28)),
        'assignment'    => array('value' => 'value'),
        'statements'    => NULL, 
      ))), $this->parse('
        foreach ($value in $list) { }
      '));
    }

    /**
     * Test while loop
     *
     */
    #[@test]
    public function whileLoop() {
      $this->assertEquals(array(new WhileNode(array(
        'position'      => array(4, 9),
        'expression'    => new ComparisonNode(array(
          'position'      => array(4, 23),
          'lhs'           => new UnaryOpNode(array(
            'position'      => array(4, 18),
            'expression'    => $this->create(new VariableNode('i'), array(4, 16)),
            'op'            => '++',
            'postfix'       => TRUE
          )),
          'rhs'           => new NumberNode(array('position' => array(4, 23), 'value' => '10000')),
          'op'            => '<'
        )),
        'statements'    => NULL, 
      ))), $this->parse('
        while ($i++ < 10000) { }
      '));
    }

    /**
     * Test foreach loop
     *
     */
    #[@test]
    public function doLoop() {
      $this->assertEquals(array(new DoNode(array(
        'position'      => array(4, 9),
        'expression'    => new ComparisonNode(array(
          'position'      => array(4, 30),
          'lhs'           => new UnaryOpNode(array(
            'position'      => array(4, 25),
            'expression'    => $this->create(new VariableNode('i'), array(4, 23)),
            'op'            => '++',
            'postfix'       => TRUE
          )),
          'rhs'           => new NumberNode(array('position' => array(4, 30), 'value' => '10000')),
          'op'            => '<'
        )),
        'statements'    => NULL, 
      ))), $this->parse('
        do { } while ($i++ < 10000)
      '));
    }
  }
?>
