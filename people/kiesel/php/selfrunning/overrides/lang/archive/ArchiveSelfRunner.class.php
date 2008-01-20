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
  class ArchiveSelfRunner extends Object {
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
      $sapi= NULL;
      switch (PHP_SAPI) {
        default:
        case 'cli': $sapi= 'cli'; break;
      }
      
      return call_user_func_array(array($this, 'run'.ucfirst($sapi)));
    }
    
    /**
     * Run program in CLI mode
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
      return $this->getClass()
        ->getClassLoader()
        ->loadClass('util.cmd.Runner')
        ->getMethod('main')
        ->invoke(
          NULL,
          array(array_merge(array(__FILE__, $className), (array)$argv))
      );
    }
  }
?>
