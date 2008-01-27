<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.Lexer',
    'xp.compiler.Parser'
  );

  /**
   * TestCase
   *
   */
  class StringTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new Parser())->parse(new xp·compiler·Lexer('class Container {
        public void method() {
          '.$src.'
        }
      }', '<string:'.$this->name.'>'))->declaration->body['methods'][0]->body;
    }

    /**
     * Test empty strings
     *
     */
    #[@test]
    public function emptyStrings() {
      $this->assertEquals(array(
        new StringNode(array('position' => array(3, 13), 'value' => '')),
        new StringNode(array('position' => array(3, 15), 'value' => '')),
      ), $this->parse('""; \'\';'));
    }

    /**
     * Test double-quoted string
     *
     */
    #[@test]
    public function doubleQuotedString() {
      $this->assertEquals(array(new StringNode(array(
        'position'      => array(4, 11),
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
        'position'      => array(4, 11),
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
        'position'      => array(4, 11),
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
        'position'      => array(4, 11),
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
        'position'      => array(4, 11),
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
