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
  class LoopTest extends ParserTestCase {
  
    /**
     * Test for loop
     *
     */
    #[@test]
    public function forLoop() {
      $this->assertEquals(array(new ForNode(array(
        'position'       => array(4, 11),
        'initialization' => array(new AssignmentNode(array(
          'position'       => array(4, 21),
          'variable'       => $this->create(new VariableNode('$i'), array(4, 16)),
          'expression'     => new NumberNode(array('position' => array(4, 20), 'value' => '0')),
          'op'             => '='
        ))),
        'condition'      => array(new ComparisonNode(array(
          'position'      => array(4, 28),
          'lhs'           => $this->create(new VariableNode('$i'), array(4, 23)),
          'rhs'           => new NumberNode(array('position' => array(4, 28), 'value' => '1000')),
          'op'            => '<'
        ))),
        'loop'           => array(new UnaryOpNode(array(
          'position'      => array(4, 36),
          'expression'    => $this->create(new VariableNode('$i'), array(4, 34)),
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
        'position'      => array(4, 11),
        'expression'    => $this->create(new VariableNode('$list'), array(4, 20)),
        'statements'    => NULL, 
      ))), $this->parse('
        foreach ($list as $key => $value) { }
      '));
    }

    /**
     * Test while loop
     *
     */
    #[@test]
    public function whileLoop() {
      $this->assertEquals(array(new WhileNode(array(
        'position'      => array(4, 11),
        'expression'    => new ComparisonNode(array(
          'position'      => array(4, 25),
          'lhs'           => new UnaryOpNode(array(
            'position'      => array(4, 20),
            'expression'    => $this->create(new VariableNode('$i'), array(4, 18)),
            'op'            => '++',
            'postfix'       => TRUE
          )),
          'rhs'           => new NumberNode(array('position' => array(4, 25), 'value' => '10000')),
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
        'position'      => array(4, 11),
        'expression'    => new ComparisonNode(array(
          'position'      => array(4, 32),
          'lhs'           => new UnaryOpNode(array(
            'position'      => array(4, 27),
            'expression'    => $this->create(new VariableNode('$i'), array(4, 25)),
            'op'            => '++',
            'postfix'       => TRUE
          )),
          'rhs'           => new NumberNode(array('position' => array(4, 32), 'value' => '10000')),
          'op'            => '<'
        )),
        'statements'    => NULL, 
      ))), $this->parse('
        do { } while ($i++ < 10000)
      '));
    }
  }
?>
