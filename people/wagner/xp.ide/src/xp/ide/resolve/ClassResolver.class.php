<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.resolve';
  
  uses(
    'xp.ide.ClassPathScanner',
    'lang.ClassLoader'
  );

  /**
   * Find a class in the source tree
   *
   * @purpose  IDE
   */
  class xp·ide·resolve·ClassResolver extends Object {

    /**
     * resolve classnames
     *
     * @param   string[] classnames
     * @param   function(FileSystemClassLoader cl, string className) fs_callback
     * @param   function(ArchiveClassLoader cl, string className)    arch_callback
     * @return  string[] args
     */
    public function resolve(array $classnames, $fs_callback, $arch_callback) {
      create(new xp·ide·ClassPathScanner())->fromCwd();
      $sources= array();
      foreach ($classnames as $className) {
        $cp= ClassLoader::getDefault()->findClass($className);
        if ($cp instanceof FileSystemClassLoader) {
          $source[]= call_user_func_array($fs_callback, array($cp, $className));
        } elseif ($cp instanceof ArchiveClassLoader) {
          $source[]= call_user_func_array($arch_callback, array($cp, $className));
        }
      }
      return $source;
    }
    
  }
?>
