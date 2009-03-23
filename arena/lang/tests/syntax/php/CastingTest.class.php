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
        'variable'      => $this->create(new VariableNode('$a'), array(4, 11)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('bool'),
          'expression'    => $this->create(new NumberNode(array('value' => '1')), array(4, 21))
        )), array(4, 22)),
        'op'            => '=',
      )), array(4, 22))), $this->parse('
        $a= (bool)1;
      '));
    }

    /**
     * Test a casting a variabke
     *
     */
    #[@test]
    public function varCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('$a'), array(4, 11)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('bool'),
          'expression'    => $this->create(new VariableNode('$v'), array(4, 21)),
        )), array(4, 23)),
        'op'            => '=',
      )), array(4, 23))), $this->parse('
        $a= (bool)$v;
      '));
    }

    /**
     * Test a cast casted
     *
     */
    #[@test]
    public function castCast() {
      $this->assertEquals(array($this->create(new AssignmentNode(array(
        'variable'      => $this->create(new VariableNode('$a'), array(4, 11)),
        'expression'    => $this->create(new CastNode(array(
          'type'          => new TypeName('bool'),
          'expression'    => $this->create(new CastNode(array(
            'type'          =>  new TypeName('string'),
            'expression'    => $this->create(new NumberNode(array('value' => '1')), array(4, 29))
          )), array(4, 30)) 
        )), array(4, 30)),
        'op'            => '=',
      )), array(4, 30))), $this->parse('
        $a= (bool)(string)1;
      '));
    }
  }
?>
