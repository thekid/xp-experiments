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
  class xp·ide·resolve·Bash extends Object {

    /**
     * print the result
     *
     * @param   string[] sources
     * @return  string
     */
    #[@output]
    public function transform(array $sources) {
      Console::$out->write(implode(' ', $sources));
    }

    /**
     * resolve a file system class
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
      Console::$err->writeLine(sprintf('Class "%s" is part of an archive: %s', $name, xp::stringOf($cp)));
    }
    
  }
?>
