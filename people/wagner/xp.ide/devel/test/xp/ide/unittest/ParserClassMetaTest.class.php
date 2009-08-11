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
  class ParserClassMetaTest extends TestCase {

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
      $this->assertObject($this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {}
         ?>
       ')), 'xp.ide.source.element.ClassFile');
    }

    /**
     * Test parser parses a comment
     *
     */
    #[@test]
    public function testParseClassFileComment() {
      $tree= $this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
         /* This class is part of the XP framework
          *
          * $Id$ 
          */

          /**
           * Test class definition
           * 
           */
          class Test extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getElement(0), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getElement(0)->getText(), ' This class is part of the XP framework
          *
          * $Id$ 
          ');
    }

    /**
     * Test parser parses a class requirement
     *
     */
    #[@test]
    public function testParseClassFileUses() {
      $tree= $this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
          uses("bla","blubb");

          /**
           * Test class definition
           * 
           */
          class Test extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getElement(0), 'xp.ide.source.element.Uses');
      $this->assertEquals($tree->getElement(0)->getClassnames(), array("bla", "blubb"));
    }

    /**
     * Test parser parses a package definition
     *
     */
    #[@test]
    public function testParseClassFilePackage() {
      $tree= $this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
          $package= "bla";

          /**
           * Test class definition
           * 
           */
          class bla愁est extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getElement(0), 'xp.ide.source.element.Package');
      $this->assertEquals($tree->getElement(0)->getPathname(), "bla");
    }

    /**
     * Test parser parses a comment an a package definition
     *
     */
    #[@test]
    public function testParseClassFileCommentPackage() {
      $tree= $this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
         /* This class is part of the XP framework
          *
          * $Id$ 
          */
          $package= "bla";

          /**
           * Test class definition
           * 
           */
          class bla愁est extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getElement(0), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getElement(0)->getText(), ' This class is part of the XP framework
          *
          * $Id$ 
          ');
      $this->assertObject($tree->getElement(1), 'xp.ide.source.element.Package');
      $this->assertEquals($tree->getElement(1)->getPathname(), "bla");
    }

    /**
     * Test parser parses a comment an a class requirement
     *
     */
    #[@test]
    public function testParseClassFileCommentUses() {
      $tree= $this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
         /* This class is part of the XP framework
          *
          * $Id$ 
          */
          uses("bla","blubb");

          /**
           * Test class definition
           * 
           */
          class bla愁est extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getElement(0), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getElement(0)->getText(), ' This class is part of the XP framework
          *
          * $Id$ 
          ');
      $this->assertObject($tree->getElement(1), 'xp.ide.source.element.Uses');
      $this->assertEquals($tree->getElement(1)->getClassnames(), array("bla", "blubb"));
    }

    /**
     * Test parser parses a comment, a package definition and a class requirement
     *
     */
    #[@test]
    public function testParseClassFileCommentPackageUses() {
      $tree= $this->p->parse(new xp搏de新ource搆arser感hp52Lexer('
        <?php
         /* This class is part of the XP framework
          *
          * $Id$ 
          */
          $package= "bla";

          uses("bla","blubb");

          /**
           * Test class definition
           * 
           */
          class bla愁est extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getElement(0), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getElement(0)->getText(), ' This class is part of the XP framework
          *
          * $Id$ 
          ');
      $this->assertObject($tree->getElement(1), 'xp.ide.source.element.Package');
      $this->assertEquals($tree->getElement(1)->getPathname(), "bla");
      $this->assertObject($tree->getElement(2), 'xp.ide.source.element.Uses');
      $this->assertEquals($tree->getElement(2)->getClassnames(), array("bla", "blubb"));
    }

  }
?>
