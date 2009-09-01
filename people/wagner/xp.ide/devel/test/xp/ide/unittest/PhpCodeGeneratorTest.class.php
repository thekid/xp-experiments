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
    'xp.ide.source.element.Classmembergroup',
    'xp.ide.source.element.Classmember',
    'xp.ide.source.element.Array',
    'xp.ide.source.element.Classmethod',
    'xp.ide.source.element.Classmethodparam',
    'xp.ide.unittest.TestCase',
    'io.streams.MemoryOutputStream',
    'xp.ide.source.Generator'
  );

  /**
   * TestCase
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
      $this->e_ad= new xp·ide·source·element·Apidoc("Apidoc to test\nthe tests\n");
      $this->e_di= new xp·ide·source·element·ApidocDirective('@test xp://xp.ide.unittest.PhpCodeGeneratorTest');
      $this->e_an= new xp·ide·source·element·Annotation('test');
      $this->e_cg= new xp·ide·source·element·Classmembergroup();
      $this->e_cm= new xp·ide·source·element·Classmember('member1');
      $this->e_ar= new xp·ide·source·element·Array();
      $this->e_me= new xp·ide·source·element·Classmethod('method1');
      $this->e_mp= new xp·ide·source·element·Classmethodparam('param1');
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodContent() {
      $this->e_me->setContent("return isset(\$this->ding) ?\n  \$this->ding :\n  new Ding;");
      $this->g->visit($this->e_me);
      $this->assertEquals("public function method1() {\n  return isset(\$this->ding) ?\n    \$this->ding :\n    new Ding;\n}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodparamTypehint() {
      $this->e_mp->setTypehint('array');
      $this->g->visit($this->e_mp);
      $this->assertEquals("array \$param1", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodparamInitArray() {
      $this->e_mp->setInit($this->e_ar);
      $this->g->visit($this->e_mp);
      $this->assertEquals("\$param1= array()", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodparamInit() {
      $this->e_mp->setInit('NULL');
      $this->g->visit($this->e_mp);
      $this->assertEquals("\$param1= NULL", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodMethodparam2() {
      $this->e_me->setParams(array($this->e_mp, new xp·ide·source·element·Classmethodparam('param2')));
      $this->g->visit($this->e_me);
      $this->assertEquals("public function method1(\$param1, \$param2) {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodMethodparam() {
      $this->e_me->setParams(array($this->e_mp));
      $this->g->visit($this->e_me);
      $this->assertEquals("public function method1(\$param1) {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodparam() {
      $this->g->visit($this->e_mp);
      $this->assertEquals("\$param1", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodAnnotation() {
      $this->e_me->setAnnotations(array($this->e_an));
      $this->g->visit($this->e_me);
      $this->assertEquals("#[@test]\npublic function method1() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodApidoc() {
      $this->e_me->setApidoc($this->e_ad);
      $this->g->visit($this->e_me);
      $this->assertEquals("/**\n * Apidoc to test\n * the tests\n * \n */\npublic function method1() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodScope() {
      $this->e_me->setScope(xp·ide·source·Scope::$PRIVATE);
      $this->g->visit($this->e_me);
      $this->assertEquals("private function method1() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodName() {
      $this->e_me->setName('othermethod');
      $this->g->visit($this->e_me);
      $this->assertEquals("public function othermethod() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodAbstract() {
      $this->e_me->setAbstract(TRUE);
      $this->g->visit($this->e_me);
      $this->assertEquals("abstract public function method1() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodFinal() {
      $this->e_me->setFinal(TRUE);
      $this->g->visit($this->e_me);
      $this->assertEquals("final public function method1() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function methodStatic() {
      $this->e_me->setStatic(TRUE);
      $this->g->visit($this->e_me);
      $this->assertEquals("public static function method1() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefMethod2() {
      $this->e_cd->setMethods(array($this->e_me, new xp·ide·source·element·Classmethod('method2')));
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object {\n  public function method1() {}\n\n  public function method2() {}\n}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefMethod() {
      $this->e_cd->setMethods(array($this->e_me));
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object {\n  public function method1() {}\n}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function method() {
      $this->g->visit($this->e_me);
      $this->assertEquals("public function method1() {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function arrayInitArray() {
      $this->e_ar->setValues(array(new xp·ide·source·element·Array(array(
        "'k1'" => "'s1'",
        "'k2'" => "1",
        0 => "'v3'"
      ))));
      $this->g->visit($this->e_ar);
      $this->assertEquals("array(\n  0 => array(\n    'k1' => 's1',\n    'k2' => 1,\n    0 => 'v3'\n  )\n)", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function arrayInit() {
      $this->e_ar->setValues(array(
        "'k1'" => "'s1'",
        "'k2'" => "1",
        0 => "'v3'"
      ));
      $this->g->visit($this->e_ar);
      $this->assertEquals("array(\n  'k1' => 's1',\n  'k2' => 1,\n  0 => 'v3'\n)", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmemberInitArray() {
      $this->e_cm->setInit($this->e_ar);
      $this->g->visit($this->e_cm);
      $this->assertEquals("\$member1= array()", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function tarray() {
      $this->g->visit($this->e_ar);
      $this->assertEquals("array()", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmemberInit() {
      $this->e_cm->setInit("'test string'");
      $this->g->visit($this->e_cm);
      $this->assertEquals("\$member1= 'test string'", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmembergroupFinalClassmember() {
      $this->e_cg->setMembers(array($this->e_cm));
      $this->e_cg->setFinal(TRUE);
      $this->g->visit($this->e_cg);
      $this->assertEquals("final public\n  \$member1;", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmembergroupStaticClassmember() {
      $this->e_cg->setMembers(array($this->e_cm));
      $this->e_cg->setStatic(TRUE);
      $this->g->visit($this->e_cg);
      $this->assertEquals("public static\n  \$member1;", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmembergroupClassmember2() {
      $this->e_cg->setMembers(array($this->e_cm, new xp·ide·source·element·Classmember('member2')));
      $this->g->visit($this->e_cg);
      $this->assertEquals("public\n  \$member1,\n  \$member2;", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefClassmembergroupClassmember() {
      $this->e_cd->setMembergroups(array($this->e_cg));
      $this->e_cg->setMembers(array($this->e_cm));
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object {\n  public\n    \$member1;\n}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmembergroupClassmember() {
      $this->e_cg->setMembers(array($this->e_cm));
      $this->g->visit($this->e_cg);
      $this->assertEquals("public\n  \$member1;", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmember() {
      $this->g->visit($this->e_cm);
      $this->assertEquals("\$member1", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classmembergroup() {
      $this->g->visit($this->e_cg);
      $this->assertEquals("", $this->o->getBytes());
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
        "/**\n * Apidoc to test\n * the tests\n * \n * @test xp://xp.ide.unittest.PhpCodeGeneratorTest\n * @see  http://xp-framework.net\n */",
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
        "/**\n * Apidoc to test\n * the tests\n * \n * @test xp://xp.ide.unittest.PhpCodeGeneratorTest\n */",
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
        "/**\n * Apidoc to test\n * the tests\n * \n */\nclass Test extends Object {}",
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
      $this->assertEquals("/**\n * Apidoc to test\n * the tests\n * \n */", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefConstant2() {
      $this->e_cd->setConstants(array('CONSTANT1' => 0, 'CONSTANT2' => 1));
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object {\n  const\n    CONSTANT1= 0,\n    CONSTANT2= 1;\n}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefConstant() {
      $this->e_cd->setConstants(array('CONSTANT1' => 0));
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object {\n  const\n    CONSTANT1= 0;\n}", $this->o->getBytes());
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
    public function classdefContent() {
      $this->e_cd->setContent("const\n  CONSTANT1= 0,\n  CONSTANT2= 1;");
      $this->g->visit($this->e_cd);
      $this->assertEquals("class Test extends Object {\n  const\n    CONSTANT1= 0,\n    CONSTANT2= 1;\n}", $this->o->getBytes());
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
    public function classdefFinal() {
      $this->e_cd->setFinal(TRUE);
      $this->g->visit($this->e_cd);
      $this->assertEquals("final class Test extends Object {}", $this->o->getBytes());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function classdefAbstract() {
      $this->e_cd->setAbstract(TRUE);
      $this->g->visit($this->e_cd);
      $this->assertEquals("abstract class Test extends Object {}", $this->o->getBytes());
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
