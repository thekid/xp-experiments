<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'io.streams.MemoryInputStream',
    'io.streams.MemoryOutputStream',
    'xp.compiler.emit.oel.Emitter',
    'xp.compiler.types.TaskScope',
    'xp.compiler.diagnostic.NullDiagnosticListener',
    'xp.compiler.io.FileManager',
    'xp.compiler.task.CompilationTask'
  );

  /**
   * TestCase
   *
   */
  abstract class ExecutionTest extends TestCase {
    protected static $syntax;
    protected static $emitter;
    protected static $scope;
    
    protected $counter= 0;
  
    /**
     * Sets up compiler API
     *
     */
    #[@beforeClass]
    public static function setupCompilerApi() {
      self::$syntax= Syntax::forName('xp');
      self::$emitter= new xp·compiler·emit·oel·Emitter();
      self::$scope= new TaskScope(new CompilationTask(
        new FileSource(new File(__FILE__), self::$syntax),
        new NullDiagnosticListener(),
        new FileManager(),
        self::$emitter
      ));
    }
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->counter= 0;
    }
    
    /**
     * Run statements and return result
     *
     * @param   string src
     * @return  var
     */
    protected function run($src) {
      return $this->define('class', ucfirst($this->name).'·'.($this->counter++), '{ public void run() { '.$src.' }}')->newInstance()->run();
    }
    
    /**
     * Define class from a given name and source
     *
     * @param   string type
     * @param   string class
     * @param   string src
     * @param   string[] imports
     * @return  lang.XPClass
     */
    protected function define($type, $class, $src, array $imports= array()) {
      $r= self::$emitter->emit(
        self::$syntax->parse(new MemoryInputStream(implode("\n", $imports).' public '.$type.' '.$class.' '.$src)), 
        self::$scope
      );
      xp::gc();

      $r->executeWith(array());
      method_exists($class, '__static') && call_user_func(array($class, '__static'));    // FIXME: This should be done in executeWith()
      return new XPClass($class);
    }
  }
?>
