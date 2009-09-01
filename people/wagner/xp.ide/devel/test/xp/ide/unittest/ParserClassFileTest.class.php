<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.streams.MemoryInputStream',
    'xp.ide.unittest.TestCase',
    'xp.ide.source.parser.ClassFileParser',
    'xp.ide.source.parser.ClassFileLexer',
    'xp.ide.source.element.ApidocDirective'
  );

  /**
   * TestCase
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
      return new xp·ide·source·parser·ClassFileLexer(new MemoryInputStream($exp));
    }

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->p= new xp·ide·source·parser·ClassFileParser();
      $this->p->setTopElement(new xp·ide·source·element·ClassFile());
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
      $this->assertEquals($tree->getPackage()->getName(), "bla");
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
      $this->assertEquals($tree->getPackage()->getName(), "bla");
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
      $this->assertEquals($tree->getPackage()->getName(), "bla");
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
       $this->assertEquals($tree->getClassdef()->getContent(), '
            $mebber bla dasfa 
            adf a
          '
      );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testApidoc() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           * 
           */
          class Test extends Object {}
        ?>
      '));
      $this->assertObject($tree->getClassdef()->getApidoc(), 'xp.ide.source.element.Apidoc');
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testApidocContent() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           *   
           */
          class Test extends Object {}
        ?>
      '));
      $this->assertEquals(
        "\nTest class definition\n  ",
        $tree->getClassdef()->getApidoc()->getText()
      );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testApidocDirective() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           * Test class definition
           *
           * @param string bla
           * @return boolean
           */
          class Test extends Object {}
        ?>
      '));
      $this->assertEquals(
        array(
          new xp·ide·source·element·ApidocDirective('@param string bla'),
          new xp·ide·source·element·ApidocDirective('@return boolean'),
        ),
        $tree->getClassdef()->getApidoc()->getDirectives()
      );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testInlineComment() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          // ...
          /**
           */
          class Test extends Object {}
        ?>
      '));
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testFinal() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           */
          final class Test extends Object {}
        ?>
      '));
      $this->assertTrue($tree->getClassdef()->isFinal());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testAbstract() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           */
          abstract class Test extends Object {}
        ?>
      '));
      $this->assertTrue($tree->getClassdef()->isAbstract());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testAnnotation() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           */
          #[@test]
          class Test extends Object {}
        ?>
      '));
      $this->assertEquals(
        array(
          new xp·ide·source·element·Annotation('test'),
        ),
        $tree->getClassdef()->getAnnotations()
      );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testAnnotations() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           */
          #[@test, @ignore]
          class Test extends Object {}
        ?>
      '));
      $this->assertEquals(
        array(
          new xp·ide·source·element·Annotation('test'),
          new xp·ide·source·element·Annotation('ingore'),
        ),
        $tree->getClassdef()->getAnnotations()
      );
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testAnnotationParam() {
      $tree= $this->p->parse($this->getLexer('
        <?php
          /**
           */
          #[@test(), @inject(type = \'lang.Object\'), @except(\'lang.XPException\'), @bla(blubb=\'Fisch\', foo=\'bar\')]
          class Test extends Object {}
        ?>
      '));
      $this->assertEquals(
        array(
          new xp·ide·source·element·Annotation('test'),
          new xp·ide·source·element·Annotation('inject', array('type' => 'lang.Object')),
          new xp·ide·source·element·Annotation('expect', array('lang.XPException')),
          new xp·ide·source·element·Annotation('bla', array('blubb' => 'Fisch', 'foo' => 'bar')),
        ),
        $tree->getClassdef()->getAnnotations()
      );
    }

  }
?>
