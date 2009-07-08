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
    private
      $status= 2;

    /**
     * print the result
     *
     * @param   string[] sources
     * @return  string
     */
    #[@output]
    public function transform(array $sources) {
      Console::$out->write(implode(PHP_EOL, $sources));
      return $this->result;
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
      $this->status= 0;
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
      $this->status= 1;
      Console::$out->writeLine(sprintf('Class "%s" is part of a XAR file: %s', $name, $cp->archive));
    }
    
    /**
     * Get status
     *
     * @return  mixed
     */
    #[@status]
    public function getStatus() {
      return $this->status;
    }

    /**
     * Set status
     *
     * @param   mixed status
     */
    public function setStatus($status) {
      $this->status= $status;
    }

  }
?>
