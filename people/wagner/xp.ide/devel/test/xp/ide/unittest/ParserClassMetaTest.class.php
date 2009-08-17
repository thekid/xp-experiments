<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.source.parser.Php52Parser'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class ParserClassMetaTest extends xp·ide·unittest·TestCase {

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->p= new xp·ide·source·parser·Php52Parser();
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

  }
?>
