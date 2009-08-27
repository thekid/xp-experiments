<?php
/* This class is part of the XP framework
 *
 * $Id:$
 */

  uses(
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.element.Package',
    'xp.ide.source.element.BlockComment',
    'xp.ide.source.element.Uses',
    'xp.ide.source.element.Classdef',
    'xp.ide.source.element.Apidoc',
    'xp.ide.source.element.ApidocDirective',
    'xp.ide.source.element.Annotation',
    'xp.ide.unittest.TestCase',
    'io.streams.MemoryOutputStream',
    'xp.ide.source.Generator'
  );

  /**
   * TestCase
   * TODO:
   *   * members
   *   * methods
   *   * constants
   *   * content
   *
   * @purpose  Test
   */
  class PhpCodeGeneratorTest extends xp·ide·unittest·TestCase {

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->o= new MemoryOutputStream();
      $this->g= new xp·ide·source·Generator($this->o);
      $this->e_cf= new xp·ide·source·element·ClassFile();
      $this->e_pg= new xp·ide·source·element·Package('xp.ide.test');
      $this->e_ch= new xp·ide·source·element·BlockComment(" This class is part of the XP framework\n *\n * \$Id:\$\n ");
      $this->e_us= new xp·ide·source·element·Uses(array('lang.Object'));
      $this->e_cd= new xp·ide·source·element·Classdef('Test');
      $this->e_ad= new xp·ide·source·element·Apidoc("Class to test\nthe tests\n");
      $this->e_di= new xp·ide·source·element·ApidocDirective('@test xp://xp.ide.unittest.PhpCodeGeneratorTest');
      $this->e_an= new xp·ide·source·element·Annotation('test');
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function annotationNamedparam2() {
      $this->e_an->setParams(array('name' => 'foo', 'name2' => 'bar'));
      $this->g->visit($this->e_an);
      $this->assertEquals("@test(name='foo',name2='bar')", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function annotationNamedparam() {
      $this->e_an->setParams(array('name' => 'foo'));
      $this->g->visit($this->e_an);
      $this->assertEquals("@test(name='foo')", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function annotationParam2() {
      $this->e_an->setParams(array('foo', 'bar'));
      $this->g->visit($this->e_an);
      $this->assertEquals("@test('foo','bar')", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function annotationParam() {
      $this->e_an->setParams(array('foo'));
      $this->g->visit($this->e_an);
      $this->assertEquals("@test('foo')", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefAnnotation2() {
      $this->e_cd->setAnnotations(array($this->e_an, new xp·ide·source·element·Annotation('ignore')));
      $this->g->visit($this->e_cd);
      $this->assertEquals("#[@test,@ignore]\nclass Test extends Object {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefAnnotation() {
      $this->e_cd->setAnnotations(array($this->e_an));
      $this->g->visit($this->e_cd);
      $this->assertEquals("#[@test]\nclass Test extends Object {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function annotation() {
      $this->g->visit($this->e_an);
      $this->assertEquals("@test", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function apidocApidocDirective2() {
      $this->e_ad->setDirectives(array(
        $this->e_di,
        new xp·ide·source·element·ApidocDirective('@see  http://xp-framework.net')
      ));
      $this->g->visit($this->e_ad);
      $this->assertEquals(
        "/**\n * Class to test\n * the tests\n * \n * @test xp://xp.ide.unittest.PhpCodeGeneratorTest\n * @see  http://xp-framework.net\n */",
        $this->o->getBytes()
      );
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function apidocApidocDirective() {
      $this->e_ad->setDirectives(array(
        $this->e_di
      ));
      $this->g->visit($this->e_ad);
      $this->assertEquals(
        "/**\n * Class to test\n * the tests\n * \n * @test xp://xp.ide.unittest.PhpCodeGeneratorTest\n */",
        $this->o->getBytes()
      );
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function apidocDirective() {
      $this->g->visit($this->e_di);
      $this->assertEquals(" * @test xp://xp.ide.unittest.PhpCodeGeneratorTest", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefApidoc() {
      $this->e_cd->setApidoc($this->e_ad);
      $this->g->visit($this->e_cd);
      $this->assertEquals(
        "/**\n * Class to test\n * the tests\n * \n */\nclass Test extends Object {}",
        $this->o->getBytes()
      );
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function apidoc() {
      $this->g->visit($this->e_ad);
      $this->assertEquals("/**\n * Class to test\n * the tests\n * \n */", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefParent() {
      $this->e_cd->setParent('Parent');
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Parent {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classfileClassdef() {
      $this->e_cf->setClassdef($this->e_cd);
      $this->g->visit($this->e_cf);
      $this->assertEquals("<?php\n  class Test extends Object {}\n?>", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefInterface2() {
      $this->e_cd->setInterfaces(array('i_face', 'i_face2'));
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object implements i_face, i_face2 {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefInterface() {
      $this->e_cd->setInterfaces(array('i_face'));
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object implements i_face {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefName() {
      $this->e_cd->setName('Test2');
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test2 extends Object {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdef() {
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classfileUses() {
      $this->e_cf->setUses($this->e_us);
      $this->g->visit($this->e_cf);
      $this->assertEquals("<?php\n  uses(\n    'lang.Object'\n  );\n?>", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function uses2() {
      $this->e_us->setClassnames(array('lang.Object', 'lang.Error'));
      $this->g->visit($this->e_us);
      $this->assertEquals("uses(\n  'lang.Object',\n  'lang.Error'\n);", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function uses() {
      $this->g->visit($this->e_us);
      $this->assertEquals("uses(\n  'lang.Object'\n);", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classfileBlockComment() {
      $this->e_cf->setHeader($this->e_ch);
      $this->g->visit($this->e_cf);
      $this->assertEquals("<?php\n/* This class is part of the XP framework\n *\n * \$Id:\$\n */\n?>", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function blockComment() {
      $this->g->visit($this->e_ch);
      $this->assertEquals("/* This class is part of the XP framework\n *\n * \$Id:\$\n */", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classfilePackage() {
      $this->e_cf->setPackage($this->e_pg);
      $this->g->visit($this->e_cf);
      $this->assertEquals("<?php\n  \$package= 'xp.ide.test';\n\n?>", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function package() {
      $this->g->visit($this->e_pg);
      $this->assertEquals("\$package= 'xp.ide.test';", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classfile() {
      $this->g->visit($this->e_cf);
      $this->assertEquals("<?php\n?>", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function out() {
      $this->assertSubclass(
        $this->g->getOutputStream(),
        'io.streams.OutputStream'
      );
    }

    /**
     * Test generate php source
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function VisitorNode() {
      $this->g->visit(new Object());
    }

  }
?>
