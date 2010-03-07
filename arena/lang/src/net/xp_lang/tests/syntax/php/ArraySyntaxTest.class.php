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
  class ArraySyntaxTest extends net·xp_lang·tests·syntax·php·ParserTestCase {
  
    /**
     * Test [1]
     *
     */
    #[@test]
    public function integerOffset() {
      $this->assertEquals(array(new ChainNode(array(
        new VariableNode('b'),
        new ArrayAccessNode(new IntegerNode('1')),
      ))), $this->parse('$b[1];'));
    }

    /**
     * Test ["a"]
     *
     */
    #[@test]
    public function stringOffset() {
      $this->assertEquals(array(new ChainNode(array(
        new VariableNode('b'),
        new ArrayAccessNode(new StringNode('a')),
      ))), $this->parse('$b["a"];'));
    }

    /**
     * Test []
     *
     */
    #[@test]
    public function noOffset() {
      $this->assertEquals(array(new ChainNode(array(
        new VariableNode('b'),
        new ArrayAccessNode(NULL),
      ))), $this->parse('$b[];'));
    }

    /**
     * Test $str{$i}
     *
     */
    #[@test]
    public function curlyBraces() {
      $this->assertEquals(array(new ChainNode(array(
        new VariableNode('str'),
        new ArrayAccessNode(new VariableNode('i')),
      ))), $this->parse('$str{$i};'));
    }
  }
?>
