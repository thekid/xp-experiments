<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('net.xp_lang.tests.syntax.php.ParserTestCase');

  /**
   * TestCase
   *
   */
  class InstanceOfTest extends net·xp_lang·tests·syntax·php·ParserTestCase {
  
    /**
     * Test instanceof a type
     *
     */
    #[@test]
    public function instanceOfObject() {
      $this->assertEquals(array(new InstanceOfNode(array(
        'expression'    => new VariableNode('a'),
        'type'          => new TypeName('Object'),
      ))), $this->parse('$a instanceof Object;'));
    }

    /**
     * Test instanceof a variable
     *
     */
    #[@test]
    public function instanceOfVariable() {
      $this->assertEquals(array(new DynamicInstanceOfNode(array(
        'expression'    => new VariableNode('a'),
        'variable'      => 'type'
      ))), $this->parse('$a instanceof $type;'));
    }
  }
?>
