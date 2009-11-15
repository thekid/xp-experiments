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
     * register classpathes in a dir hierarchy
     *
     * @param io.Folder folder
     * @return  bool true if any classpath was registered
     */
    public function fromFolder(Folder $folder) {
      list($s, $csd)= explode('://', $folder->getUri(), 2);
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
