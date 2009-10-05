<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution.oel';

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
  abstract class tests·execution·oel·ExecutionTest extends TestCase {
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
      if (!function_exists('oel_new_op_array')) {
        throw new PrerequisitesNotMetError('OEL extension not loaded', NULL, 'oel');
      }
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
     * @param   string[] imports
     * @return  var
     */
    protected function run($src, array $imports= array()) {
      return $this->define(
        'class', 
        ucfirst($this->name).'·'.($this->counter++), 
        NULL,
        '{ public void run() { '.$src.' }}',
        $imports
      )->newInstance()->run();
    }
    
    /**
     * Define class from a given name and source
     *
     * @param   string type
     * @param   string class
     * @param   string parent
     * @param   string src
     * @param   string[] imports
     * @return  lang.XPClass
     */
    protected function define($type, $class, $parent, $src, array $imports= array()) {
      $class= 'Oel'.$class;
      $r= self::$emitter->emit(
        self::$syntax->parse(new MemoryInputStream(
          implode("\n", $imports).
          ' public '.$type.' '.$class.' '.($parent ? ' extends '.$parent : '').$src
        ), $this->name), 
        self::$scope
      );
      xp::gc();

      $r->executeWith(array());
      method_exists($class, '__static') && call_user_func(array($class, '__static'));    // FIXME: This should be done in executeWith()
      return new XPClass($class);
    }
  }
?>
