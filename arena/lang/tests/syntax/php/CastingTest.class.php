<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.syntax.php.ParserTestCase');

  /**
   * TestCase
   *
   */
  class CastingTest extends tests·syntax·php·ParserTestCase {
  
    /**
     * Test a bool-cast
     *
     */
    #[@test]
    public function boolCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('bool'),
          'expression'    => $this->create(new IntegerNode('1'), array(4, 19))
        )), array(4, 20)),
        'op'            => '=',
      )), array(4, 20))), $this->parse('
        $a= (bool)1;
      '));
    }

    /**
     * Test a string-cast
     *
     */
    #[@test]
    public function stringCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('string'),
          'expression'    => $this->create(new IntegerNode('1'), array(4, 21))
        )), array(4, 22)),
        'op'            => '=',
      )), array(4, 22))), $this->parse('
        $a= (string)1;
      '));
    }

    /**
     * Test an array-cast
     *
     */
    #[@test]
    public function arrayCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('var[]'),
          'expression'    => $this->create(new IntegerNode('1'), array(4, 20))
        )), array(4, 21)),
        'op'            => '=',
      )), array(4, 21))), $this->parse('
        $a= (array)1;
      '));
    }

    /**
     * Test an int-cast
     *
     */
    #[@test]
    public function intCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('int'),
          'expression'    => $this->create(new IntegerNode('1'), array(4, 18))
        )), array(4, 19)),
        'op'            => '=',
      )), array(4, 19))), $this->parse('
        $a= (int)1;
      '));
    }

    /**
     * Test an double-cast
     *
     */
    #[@test]
    public function doubleCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('double'),
          'expression'    => $this->create(new IntegerNode('1'), array(4, 21))
        )), array(4, 22)),
        'op'            => '=',
      )), array(4, 22))), $this->parse('
        $a= (double)1;
      '));
    }

    /**
     * Test a casting a variabke
     *
     */
    #[@test]
    public function varCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('bool'),
          'expression'    => $this->create(new VariableNode('v'), array(4, 19)),
        )), array(4, 21)),
        'op'            => '=',
      )), array(4, 21))), $this->parse('
        $a= (bool)$v;
      '));
    }

    /**
     * Test an invocation with a constants as argument is not confused with a cast
     *
     */
    #[@test]
    public function invocationWithConstantArg() {
      $this->assertEquals(array($this->create(new InvocationNode(array(
        'name'          => 'init',
        'parameters'    => array(
          $this->create(new BooleanNode(TRUE), array(4, 18))
        ),
      )), array(4, 13))), $this->parse('
        init(TRUE);
      '));
    }

    /**
     * Test a cast casted
     *
     */
    #[@test]
    public function castCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('a'), array(4, 9)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('bool'),
          'expression'    => $this->create(new CastNode(array(
            'type'          =>  new TypeName('string'),
            'expression'    => $this->create(new IntegerNode('1'), array(4, 27))
          )), array(4, 28)) 
        )), array(4, 28)),
        'op'            => '=',
      )), array(4, 28))), $this->parse('
        $a= (bool)(string)1;
      '));
    }
  }
?>
