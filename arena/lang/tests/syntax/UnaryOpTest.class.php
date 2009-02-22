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
  class UnaryOpTest extends ParserTestCase {
  
    /**
     * Test negation
     *
     */
    #[@test]
    public function negation() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 14),
        'expression'    => $this->create(new VariableNode('$i'), array(4, 12)),
        'op'            => '!'
      ))), $this->parse('
        !$i;
      '));
    }

    /**
     * Test complement
     *
     */
    #[@test]
    public function complement() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 14),
        'expression'    => $this->create(new VariableNode('$i'), array(4, 12)),
        'op'            => '~'
      ))), $this->parse('
        ~$i;
      '));
    }

    /**
     * Test increment
     *
     */
    #[@test]
    public function increment() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 15),
        'expression'    => $this->create(new VariableNode('$i'), array(4, 13)),
        'op'            => '++'
      ))), $this->parse('
        ++$i;
      '));
    }

    /**
     * Test decrement
     *
     */
    #[@test]
    public function decrement() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 15),
        'expression'    => $this->create(new VariableNode('$i'), array(4, 13)),
        'op'            => '--'
      ))), $this->parse('
        --$i;
      '));
    }
  }
?>
