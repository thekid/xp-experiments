<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.resolve';
  
  uses(
    'util.cmd.Console'
  );
  
  /**
   * Find a class in the source tree
   *
   * @purpose  IDE
   */
  class xp·ide·resolve·Nedit extends Object {

    /**
     * resolve a fiel system class
     *
     * @param   string[] sources
     * @return  string
     */
    #[@output]
    public function transform(array $sources) {
      Console::$out->write(implode(PHP_EOL, $sources));
      return 0;
    }

    /**
     * resolve a fiel system class
     *
     * @param   lang.FileSystemClassLoader cp
     * @param   string name
     * @return  string
     */
    #[@resolve(type="lang.FileSystemClassLoader")]
    public function resolveToFile(FileSystemClassLoader $cp, $name) {
      return $cp->path.strtr($name, '.', DIRECTORY_SEPARATOR).xp::CLASS_FILE_EXT;
    }

    /**
     * resolve a xar class
     *
     * @param   lang.archive.ArchiveClassLoader cp
     * @param   string name
     * @return  string
     */
    #[@resolve(type="lang.archive.ArchiveClassLoader")]
    public function resolveToArchive(ArchiveClassLoader $cp, $name) {
      return $cp->archive;
    }
    
  }
?>
