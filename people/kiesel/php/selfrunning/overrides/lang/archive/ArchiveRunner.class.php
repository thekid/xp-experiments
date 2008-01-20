<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.Properties');

  /**
   * ArchiveRunner contains bootstrap code for self-running XARs.
   * It determines which class to run, loads and invokes it.
   *
   * @purpose  Self-running bootstrapping
   */
  class ArchiveRunner extends Object {
    public static
      $manifest   = NULL;
    
    /**
     * Load the manifest file
     *
     * @return  util.Properties
     */
    protected function manifest() {
      if (NULL === self::$manifest) {
        self::$manifest= Properties::fromString(
          $this->getClass()
          ->getClassLoader()
          ->getResource('META-INF/manifest.ini')
        );
      }
      
      return self::$manifest;
    }
    
    /**
     * Run program.
     *
     * This method determines the sapi and passes execution to a sapi
     * handler if the sapi is supported.
     *
     * @return  int exitcode
     */
    public function run() {

      // Determine the current SAPI and apply the corresponding
      // bootstrapping
      switch (PHP_SAPI) {
        default:
        case 'cli': {
          $sapi= 'cli'; 
          break;
        }
        
        case 'cgi':
        case 'cgi-fcgi':
        case 'apache':
        case 'apache2handler': {
          $sapi= 'web';
          break;
        }
      }

      return call_user_func(array($this, 'run'.ucfirst($sapi)));
    }
    
    /**
     * Run program in "cli" sapi
     *
     * @return  int exitcode
     */
    protected function runCli() {
    
      // Little hackish, but needed, because $argv cannot be passed from the
      // calling method, because that method is SAPI independent and therefore
      // should not know about $argv.
      $argv= $GLOBALS['argv'];
      
      // The first argument is the name of the .xar, so remove it
      array_shift($argv);
      
      if (sizeof($argv) >= 2 && '-class' == $argv[0]) {
        $className= $argv[1];
        array_shift($argv);
        array_shift($argv);
      } else {
        $className= $this->manifest()->readString('runnable', 'main-class');
      }
      
      // Run the class with xpcli / util.cmd.Runner
      try {
        return ClassLoader::getDefault()
          ->loadClass('util.cmd.Runner')
          ->getMethod('main')
          ->invoke(NULL, array(array_merge(array(__FILE__, $className), (array)$argv)))
        ;
      } catch (Throwable $e) {
        $e->printStackTrace();
        return 0x3d;  // Error code for failure from lang.base.php
      }
    }
    
    /**
     * Run program in "web" sapi
     *
     * @return  int exitcode
     */
    protected function runWeb() {
      raise('lang.MethodNotImplementedException', 'Running "web" sapi is not yet supported.');
    }    
  }
?>
