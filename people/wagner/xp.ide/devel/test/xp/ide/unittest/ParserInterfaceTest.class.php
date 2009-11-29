<?php
/* This class is part of the XP framework
 *
 * $Id: ParserClassTest.class.php 11628 2009-11-09 22:51:33Z ruben $ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.source.parser.InterfaceParser',
    'xp.ide.source.parser.ClassLexer',
    'xp.ide.source.Scope',
    'io.streams.MemoryInputStream',
    'io.streams.TextReader'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class ParserInterfaceTest extends xp·ide·unittest·TestCase {

    /**
     * lexer to do tests with
     *
     * @param string exp
     * @return xp.ide.source.parser.Lexer
     */
    private function getLexer($exp) {
      return new xp·ide·source·parser·ClassLexer(new TextReader(new MemoryInputStream($exp)));
    }

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->p= new xp·ide·source·parser·InterfaceParser();
      $this->p->setTopElement(new xp·ide·source·element·InterfaceDef('Test'));
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethodApidoc() {
      $tree= $this->p->parse($this->getLexer('
        /**
         * test
         */
        function method1();
      '));
      $this->assertClass($tree->getMethod(0)->getApidoc(), 'xp.ide.source.element.Apidoc');
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethodParamInitArray() {
      $tree= $this->p->parse($this->getLexer('
        function method1($a= array());
      '));
      $this->assertClass($tree->getMethod(0)->getParam(0)->getInit(), 'xp.ide.source.element.Array');
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethodParamInit() {
      $tree= $this->p->parse($this->getLexer('
        function method1($a= "b");
      '));
      $this->assertEquals('"b"', $tree->getMethod(0)->getParam(0)->getInit());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethodParamHint() {
      $tree= $this->p->parse($this->getLexer('
        function method1(array $a);
      '));
      $this->assertEquals('array', $tree->getMethod(0)->getParam(0)->getTypehint());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethodParam() {
      $tree= $this->p->parse($this->getLexer('
        function method1($a);
      '));
      $this->assertEquals(1, count($tree->getMethod(0)->getParams()));
      $this->assertClass($tree->getMethod(0)->getParam(0), 'xp.ide.source.element.Classmethodparam');
      $this->assertEquals('a', $tree->getMethod(0)->getParam(0)->getName());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function testMethodModPrivate() {
      $tree= $this->p->parse($this->getLexer('
        private function method1();
      '));
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethodMod() {
      $tree= $this->p->parse($this->getLexer('
        public function method1();
      '));
      $this->assertEquals(xp·ide·source·Scope::$PUBLIC, $tree->getMethod(0)->getScope());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethods() {
      $tree= $this->p->parse($this->getLexer('
        function method1();
        function method2();
      '));
      $this->assertClass($tree->getMethod(0), 'xp.ide.source.element.Classmethod');
      $this->assertEquals('method1', $tree->getMethod(0)->getName());
      $this->assertEquals('method2', $tree->getMethod(1)->getName());
    }

    /**
     * Test parser parses a classfile
     *
     */
    #[@test]
    public function testMethod() {
      $tree= $this->p->parse($this->getLexer('
        function method1();
      '));
      $this->assertClass($tree->getMethod(0), 'xp.ide.source.element.Classmethod');
      $this->assertEquals('method1', $tree->getMethod(0)->getName());
    }

  }
?>
