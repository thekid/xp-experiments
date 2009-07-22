<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';
  
  uses(
    'lang.ClassLoader'
  );

  /**
   * Scan directorie for classpathes
   *
   * @purpose  IDE
   */
  class xp·ide·ClassPathScanner extends Object {

    /**
     * register classpathes in the CWD hierarchy
     *
     * @return  bool true if any classpath was registered
     */
    public function fromCwd() {
      $csd= getcwd();
      do {
        if ($paths= scanpath(array($csd), getenv('HOME'))) {
          foreach (explode(PATH_SEPARATOR, $paths) as $path) ClassLoader::registerPath($path);
          return TRUE;
        }
        $oldcsd= $csd;
        $csd= dirname($csd);
      } while ($oldcsd !== $csd);
      return FALSE;
    }
  }
?>
