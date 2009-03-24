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
  class ControlStructuresTest extends ParserTestCase {
  
    /**
     * Test if statement without else
     *
     */
    #[@test]
    public function ifStatement() {
      $this->assertEquals(array(new IfNode(array(
        'position'       => array(4, 9),
        'condition'      => $this->create(new VariableNode('$i'), array(4, 13)),
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
        'position'       => array(4, 9),
        'condition'      => $this->create(new VariableNode('$i'), array(4, 13)),
        'statements'     => array(new ReturnNode(array(
          'position'       => array(4, 17),
          'expression'     => new ConstantNode(array(
            'position'       => array(4, 28),
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
        'position'       => array(4, 9),
        'condition'      => $this->create(new VariableNode('$i'), array(4, 13)),
        'statements'     => NULL, 
        'otherwise'      => new ElseNode(array(
          'position'       => array(4, 21),
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
        'position'       => array(4, 9),
        'condition'      => new BinaryOpNode(array(
          'position'       => array(4, 19),
          'lhs'            => $this->create(new VariableNode('$i'), array(4, 13)),
          'rhs'            => new NumberNode(array('position' => array(4, 18), 'value' => '3')),
          'op'             => '%'
        )),
        'statements'     => NULL, 
        'otherwise'      => new ElseNode(array(
          'position'       => array(4, 25),
          'statements'     => array(new IfNode(array(
            'position'       => array(4, 30),
            'condition'      => new BinaryOpNode(array(
              'position'       => array(4, 40),
              'lhs'            => $this->create(new VariableNode('$i'), array(4, 34)),
              'rhs'            => new NumberNode(array('position' => array(4, 39), 'value' => '2')),
              'op'             => '%'
            )),
            'statements'     => NULL, 
            'otherwise'      => new ElseNode(array(
              'position'       => array(4, 46),
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
        'position'       => array(4, 9),
        'expression'     => $this->create(new VariableNode('$i'), array(4, 17)),
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
        'position'       => array(4, 9),
        'expression'     => $this->create(new VariableNode('$i'), array(4, 17)),
        'cases'          => array(
          new CaseNode(array(
            'position'       => array(5, 11),
            'expression'     => new NumberNode(array('position' => array(5, 16), 'value' => '0')),
            'statements'     => array(
              new StringNode(array('position' => array(5, 19), 'value' => 'no entries')),
              new BreakNode(array('position' => array(5, 33)))
            )
          )),
          new CaseNode(array(
            'position'       => array(6, 11),
            'expression'     => new NumberNode(array('position' => array(6, 16), 'value' => '1')),
            'statements'     => array(
              new StringNode(array('position' => array(6, 19), 'value' => 'one entry')),
              new BreakNode(array('position' => array(6, 32)))
            )
         )),
          new DefaultNode(array(
            'position'       => array(7, 11),
            'statements'     => array(
              new BinaryOpNode(array(
                'position'   => array(7, 35),
                'lhs'        => $this->create(new VariableNode('$i'), array(7, 20)),
                'rhs'        => new StringNode(array('position' => array(7, 25), 'value' => ' entries')),
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
