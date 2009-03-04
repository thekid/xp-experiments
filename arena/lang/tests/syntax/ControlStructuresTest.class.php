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
  class ControlStructuresTest extends ParserTestCase {
  
    /**
     * Test if statement without else
     *
     */
    #[@test]
    public function ifStatement() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 11),
        'condition'      => $this->create(new VariableNode('$i'), array(4, 15)),
        'statements'     => NULL,
        'otherwise'      => NULL, 
      ))), $this->parse('
        if ($i) { }
      '));
    }

    /**
     * Test if statement without curly braces
     *
     */
    #[@test]
    public function ifStatementWithOutCurlies() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 11),
        'condition'      => $this->create(new VariableNode('$i'), array(4, 15)),
        'statements'     => array(new ReturnNode(array(
          'position'       => array(4, 19),
          'expression'     => new ConstantNode(array(
            'position'       => array(4, 30),
            'value'          => 'true'
          ))
        ))),
        'otherwise'      => NULL, 
      ))), $this->parse('
        if ($i) return true;
      '));
    }

    /**
     * Test if statement with else
     *
     */
    #[@test]
    public function ifElseStatement() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 11),
        'condition'      => $this->create(new VariableNode('$i'), array(4, 15)),
        'statements'     => NULL, 
        'otherwise'      => new ElseNode(array(
          'position'       => array(4, 23),
          'statements'     => NULL,
        )), 
      ))), $this->parse('
        if ($i) { } else { }
      '));
    }

    /**
     * Test if /else cascades
     *
     */
    #[@test]
    public function ifElseCascades() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 11),
        'condition'      => new BinaryOpNode(array(
          'position'       => array(4, 21),
          'lhs'            => $this->create(new VariableNode('$i'), array(4, 15)),
          'rhs'            => new NumberNode(array('position' => array(4, 20), 'value' => '3')),
          'op'             => '%'
        )),
        'statements'     => NULL, 
        'otherwise'      => new ElseNode(array(
          'position'       => array(4, 27),
          'statements'     => array(new IfNode(array(
            'position'       => array(4, 32),
            'condition'      => new BinaryOpNode(array(
              'position'       => array(4, 42),
              'lhs'            => $this->create(new VariableNode('$i'), array(4, 36)),
              'rhs'            => new NumberNode(array('position' => array(4, 41), 'value' => '2')),
              'op'             => '%'
            )),
            'statements'     => NULL, 
            'otherwise'      => new ElseNode(array(
              'position'       => array(4, 48),
              'statements'     => NULL,
            )), 
          ))),
        )), 
      ))), $this->parse('
        if ($i % 3) { } else if ($i % 2) { } else { }
      '));
    }

    /**
     * Test switch statement
     *
     */
    #[@test]
    public function emptySwitchStatement() {
      $this->assertEquals(array(new SwitchNode(array(
        'position'       => array(4, 11),
        'expression'     => $this->create(new VariableNode('$i'), array(4, 19)),
        'cases'          => NULL,
      ))), $this->parse('
        switch ($i) { }
      '));
    }

    /**
     * Test switch statement
     *
     */
    #[@test]
    public function switchStatement() {
      $this->assertEquals(array(new SwitchNode(array(
        'position'       => array(4, 11),
        'expression'     => $this->create(new VariableNode('$i'), array(4, 19)),
        'cases'          => array(
          new CaseNode(array(
            'position'       => array(5, 13),
            'expression'     => new NumberNode(array('position' => array(5, 18), 'value' => '0')),
            'statements'     => array(
              new StringNode(array('position' => array(5, 21), 'value' => 'no entries')),
              new BreakNode(array('position' => array(5, 33)))
            )
          )),
          new CaseNode(array(
            'position'       => array(6, 13),
            'expression'     => new NumberNode(array('position' => array(6, 18), 'value' => '1')),
            'statements'     => array(
              new StringNode(array('position' => array(6, 21), 'value' => 'one entry')),
              new BreakNode(array('position' => array(6, 32)))
            )
         )),
          new DefaultNode(array(
            'position'       => array(7, 13),
            'statements'     => array(
              new BinaryOpNode(array(
                'position'   => array(7, 35),
                'lhs'        => $this->create(new VariableNode('$i'), array(7, 22)),
                'rhs'        => new StringNode(array('position' => array(7, 27), 'value' => ' entries')),
                'op'         => '~'
              )),
              new BreakNode(array('position' => array(7, 37)))
            )
          ))
        ),
      ))), $this->parse('
        switch ($i) { 
          case 0: "no entries"; break;
          case 1: "one entry"; break;
          default: $i ~ " entries"; break;
        }
      '));
    }
  }
?>
