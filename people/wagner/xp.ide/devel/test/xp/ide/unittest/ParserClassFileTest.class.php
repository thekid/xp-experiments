<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.source.parser.ClassFileParser',
    'xp.ide.source.parser.ClassFileLexer'
  );

  /**
   * TestCase
   * TODO:
   *  - Annotation class
   *  - API doc class
   *
   * @see      reference
   * @purpose  purpose
   */
  class ParserClassFileTest extends xp·ide·unittest·TestCase {

    /**
     * lexer to do tests with
     *
     * @param string exp
     * @return text.parser.generic.AbstractLexer
     */
    private function getLexer($exp) {
      return new xp·ide·source·parser·ClassFileLexer($exp);
    }

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->p= new xp·ide·source·parser·ClassFileParser();
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testParseClassFile() {
      $this->assertObject($this->p->parse($this->getLexer('
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
      $tree= $this->p->parse($this->getLexer('
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
      $this->assertObject($tree->getHeader(), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getHeader()->getText(), ' This class is part of the XP framework
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
      $tree= $this->p->parse($this->getLexer('
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
      $this->assertObject($tree->getUses(), 'xp.ide.source.element.Uses');
      $this->assertEquals($tree->getUses()->getClassnames(), array("bla", "blubb"));
    }

    /**
     * Test parser parses a package definition
     *
     */
    #[@test]
    public function testParseClassFilePackage() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          $package= "bla";

          /**
           * Test class definition
           * 
           */
          class bla·Test extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getPackage(), 'xp.ide.source.element.Package');
      $this->assertEquals($tree->getPackage()->getPathname(), "bla");
    }

    /**
     * Test parser parses a comment an a package definition
     *
     */
    #[@test]
    public function testParseClassFileCommentPackage() {
      $tree= $this->p->parse($this->getLexer('
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
          class bla·Test extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getHeader(), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getHeader()->getText(), ' This class is part of the XP framework
          *
          * $Id$ 
          ');
      $this->assertObject($tree->getPackage(), 'xp.ide.source.element.Package');
      $this->assertEquals($tree->getPackage()->getPathname(), "bla");
    }

    /**
     * Test parser parses a comment an a class requirement
     *
     */
    #[@test]
    public function testParseClassFileCommentUses() {
      $tree= $this->p->parse($this->getLexer('
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
          class bla·Test extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getHeader(), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getHeader()->getText(), ' This class is part of the XP framework
          *
          * $Id$ 
          ');
      $this->assertObject($tree->getUses(), 'xp.ide.source.element.Uses');
      $this->assertEquals($tree->getUses()->getClassnames(), array("bla", "blubb"));
    }

    /**
     * Test parser parses a comment, a package definition and a class requirement
     *
     */
    #[@test]
    public function testParseClassFileCommentPackageUses() {
      $tree= $this->p->parse($this->getLexer('
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
          class bla·Test extends Object {}
        ?>
      '));
      $this->assertObject($tree, 'xp.ide.source.element.ClassFile');
      $this->assertObject($tree->getHeader(), 'xp.ide.source.element.BlockComment');
      $this->assertEquals($tree->getHeader()->getText(), ' This class is part of the XP framework
          *
          * $Id$ 
          ');
      $this->assertObject($tree->getPackage(), 'xp.ide.source.element.Package');
      $this->assertEquals($tree->getPackage()->getPathname(), "bla");
      $this->assertObject($tree->getUses(), 'xp.ide.source.element.Uses');
      $this->assertEquals($tree->getUses()->getClassnames(), array("bla", "blubb"));
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testParseClass() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {}
         ?>
       '));
       $this->assertObject($tree->getClassdef(), 'xp.ide.source.element.Classdef');
       $this->assertEquals($tree->getClassdef()->getName(), 'Test');
       $this->assertEquals($tree->getClassdef()->getParent(), 'Object');
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testParseClassInterface() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object implements ITest, ITest2 {}
         ?>
       '));
       $this->assertEquals($tree->getClassdef()->getInterfaces(), array('ITest', 'ITest2'));
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testWithBody() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {
            $mebber bla dasfa 
            adf a
          }
         ?>
       '));
       $this->assertObject($tree->getClassdef(), 'xp.ide.source.element.Classdef');
       $this->assertEquals($tree->getClassdef()->getName(), 'Test');
       $this->assertEquals($tree->getClassdef()->getParent(), 'Object');
    }

  }
?>
