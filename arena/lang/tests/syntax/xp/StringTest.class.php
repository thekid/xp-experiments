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
  class StringTest extends ParserTestCase {
  
    /**
     * Test empty strings
     *
     */
    #[@test]
    public function emptyStrings() {
      $this->assertEquals(array(
        new StringNode(array('position' => array(3, 13), 'value' => '')),
        new StringNode(array('position' => array(3, 17), 'value' => '')),
      ), $this->parse('""; \'\';'));
    }

    /**
     * Test double-quoted string
     *
     */
    #[@test]
    public function doubleQuotedString() {
      $this->assertEquals(array(new StringNode(array(
        'position'      => array(4, 9),
        'value'         => 'Hello World',
      ))), $this->parse('
        "Hello World";
      '));
    }

    /**
     * Test double-quoted string
     *
     */
    #[@test]
    public function doubleQuotedStringWithEscapes() {
      $this->assertEquals(array(new StringNode(array(
        'position'      => array(4, 9),
        'value'         => '"Hello", he said',
      ))), $this->parse('
        "\"Hello\", he said";
      '));
    }

    /**
     * Test single-quoted string
     *
     */
    #[@test]
    public function singleQuotedString() {
      $this->assertEquals(array(new StringNode(array(
        'position'      => array(4, 9),
        'value'         => 'Hello World',
      ))), $this->parse("
        'Hello World';
      "));
    }

    /**
     * Test single-quoted string
     *
     */
    #[@test]
    public function singleQuotedStringWithEscapes() {
      $this->assertEquals(array(new StringNode(array(
        'position'      => array(4, 9),
        'value'         => "Timm's e-mail address",
      ))), $this->parse("
        'Timm\'s e-mail address';
      "));
    }

    /**
     * Test single-quoted string
     *
     */
    #[@test]
    public function multiLineString() {
      $this->assertEquals(array(new StringNode(array(
        'position'      => array(4, 9),
        'value'         => 'This
         is 
         a
         multiline
         string',
      ))), $this->parse("
        'This
         is 
         a
         multiline
         string';
      "));
    }
  }
?>
