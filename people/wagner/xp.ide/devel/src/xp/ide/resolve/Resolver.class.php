<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.resolve';
  
  uses(
    'lang.FileSystemClassLoader',
    'lang.archive.ArchiveClassLoader',
    'xp.ide.resolve.NoSourceException'
  );
  
  /**
   * Find a class in the source tree
   *
   * @purpose  IDE
   */
  class xp·ide·resolve·Resolver extends Object {

    /**
     * resolve a class name
     *
     * @param   string name
     * @return  string
     * @throws  lang.IllegalArgumentException
     * @throws  xp.ide.resolve.NoSourceException
     */
    public function getSourceUri($name) {
      if (empty($name)) throw new IllegalArgumentException("name is empty");
      $cp= ClassLoader::getDefault()->findClass($name);
      if (!$cp instanceof NULL) switch ($cp->getClassName()) {
        case 'lang.FileSystemClassLoader':
        return $this->resolveFscl($cp, $name);

        case 'lang.archive.ArchiveClassLoader':
        return $this->resolveAcl($cp, $name);
      }
      throw new xp·ide·resolve·NoSourceException(sprintf("%s has no source file", $name));
    }

    /**
     * resolve a file system class
     *
     * @param   lang.FileSystemClassLoader cp
     * @param   string name
     * @return  string
     */
    protected function resolveFscl(FileSystemClassLoader $cp, $name) {
      return 'file://'.$cp->path.strtr($name, '.', DIRECTORY_SEPARATOR).xp::CLASS_FILE_EXT;
    }

    /**
     * resolve a xar class
     *
     * @param   lang.archive.ArchiveClassLoader cp
     * @param   string name
     * @return  string
     */
    protected function resolveAcl(ArchiveClassLoader $cp, $name) {
      list($filename)= sscanf($cp->toString(), $cp->getClassName().'<%s>');
      return $filename;
    }
    
  }
?>
