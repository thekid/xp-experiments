<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xp.ide.source.parser.Php52Parser',
    'xp.ide.source.parser.Php52Lexer'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class ParserTest extends TestCase {

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->p= new xp搏de新ource搆arser感hp52Parser();
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testParseClassFile() {
      $this->assertObject($this->p->parse(new xp搏de新ource搆arser感hp52Lexer('<?php ?>')), 'xp.ide.source.element.ClassFile');
    }

    /**
     * Test parser parses a comment
     *
     */
    #[@test]
    public function testParseClassFileComment() {
      $tree= $this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
          /**
           * block comment
           *
           */
         ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getElement(0), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getElement(0)->getText(), '*
           * block comment
           *
           ');
    }

  }
?>
