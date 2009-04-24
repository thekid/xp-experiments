<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'io.streams.MemoryInputStream',
    'xp.compiler.Syntax',
    'xp.compiler.emit.oel.Emitter',
    'xp.compiler.io.FileManager'
  );

  /**
   * TestCase
   *
   */
  abstract class ExecutionTest extends TestCase {
    protected static $syntax;
    protected static $emitter;
    protected static $manager;
    
    protected $counter= 0;
  
    /**
     * Sets up compiler API
     *
     */
    #[@beforeClass]
    public static function setupCompilerApi() {
      self::$syntax= Syntax::forName('xp');
      self::$emitter= new xp·compiler·emit·oel·Emitter();
      self::$manager= new FileManager();
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
     * @return  lang.XPClass
     */
    protected function define($type, $class, $src) {
      $r= self::$emitter->emit(
        self::$syntax->parse(new MemoryInputStream('public '.$type.' '.$class.' '.$src)), 
        self::$manager
      );
      xp::gc();

      $r->executeWith(array());
      method_exists($class, '__static') && call_user_func(array($class, '__static'));    // FIXME: This should be done in executeWith()
      return new XPClass($class);
    }
  }
?>
