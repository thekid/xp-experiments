<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'io.streams.MemoryInputStream',
    'xp.compiler.emit.source.Emitter',
    'xp.compiler.types.TaskScope',
    'xp.compiler.diagnostic.NullDiagnosticListener',
    'xp.compiler.io.FileManager',
    'xp.compiler.task.CompilationTask'
  );

  /**
   * TestCase
   *
   * @see   xp://xp.compiler.types.CompiledType
   */
  class TypeTest extends TestCase {
    protected $scope;
    protected $emitter;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->emitter= new xp·compiler·emit·source·Emitter();
      $this->scope= new TaskScope(new CompilationTask(
        new FileSource(new File(__FILE__), Syntax::forName('xp')),
        new NullDiagnosticListener(),
        new FileManager(),
        $this->emitter
      ));
    }

    /**
     * Compile class from source and return compiled type
     *
     * @param   string src
     * @return  xp.compiler.types.Types
     */
    protected function compile($src) {
      $r= $this->emitter->emit(
        Syntax::forName('xp')->parse(new MemoryInputStream($src)),
        $this->scope
      );
      return $r->type();
    }

    /**
     * Test hasField() on compiled type
     *
     */
    #[@test]
    public function classFieldExists() {
      $t= $this->compile('class Person { public string $name; }');
      $this->assertTrue($t->hasField('name'));
    }

    /**
     * Test hasField() on compiled type
     *
     */
    #[@test]
    public function classStaticFieldExists() {
      $t= $this->compile('class Logger { public static self $instance; }');
      $this->assertTrue($t->hasField('instance'));
    }
    
    /**
     * Test hasField() on compiled type
     *
     */
    #[@test]
    public function enumFieldExists() {
      $t= $this->compile('enum Days { MON, TUE, WED, THU, FRI, SAT, SUN }');
      $this->assertTrue($t->hasField('MON'));
    }

    /**
     * Test hasConstant() on compiled type
     *
     */
    #[@test]
    public function classConstantExists() {
      $t= $this->compile('class StringConstants { const string LF= "\n"; }');
      $this->assertTrue($t->hasConstant('LF'));
    }

    /**
     * Test hasConstant() on compiled type
     *
     */
    #[@test]
    public function interfaceConstantExists() {
      $t= $this->compile('interface StringConstants { const string LF= "\n"; }');
      $this->assertTrue($t->hasConstant('LF'));
    }

    /**
     * Test hasMethod() on compiled type
     *
     */
    #[@test]
    public function classMethodExists() {
      $t= $this->compile('class String { public self substring(int $start, int $len) { }}');
      $this->assertTrue($t->hasMethod('substring'));
    }

    /**
     * Test hasMethod() on compiled type
     *
     */
    #[@test]
    public function enumMethodExists() {
      $t= $this->compile('enum Coin { penny(1), nickel(2), dime(10), quarter(25); public string color() { }}');
      $this->assertTrue($t->hasMethod('color'));
    }
  }
?>
