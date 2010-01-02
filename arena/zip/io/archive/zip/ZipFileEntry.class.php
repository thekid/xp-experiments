<?php
/* This class is part of the XP framework
 *
 * $Id: ZipFileEntry.class.php 11840 2010-01-02 13:58:25Z friebe $ 
 */

  uses('io.archive.zip.ZipEntry');

  /**
   * Represents a file entry in a zip archive
   *
   * @see      xp://io.archive.zip.ZipEntry
   * @purpose  Interface
   */
  class ZipFileEntry extends Object implements ZipEntry {
    protected 
      $name = '', 
      $mod  = NULL;
    
    public
      $is   = NULL,
      $os   = NULL;
        
    /**
     * Constructor
     *
     * @param   string name
     * @param   util.Date modified default NULL
     */
    public function __construct($name, Date $modified= NULL) {
      $this->name= str_replace('\\', '/', $name);
      $this->mod= $modified ? $modified : Date::now();
    }
    
    /**
     * Gets a zip entry's name
     *
     * @return  string
     */
    public function getName() {
      return $this->name;
    }
    
    /**
     * Gets a zip entry's last modification time
     *
     * @return  util.Date
     */
    public function lastModified() {
      return $this->mod;
    }

    /**
     * Returns whether this entry is a directory
     *
     * @return  bool
     */
    public function isDirectory() {
      return FALSE;
    }

    /**
     * Returns an input stream for reading from this entry
     *
     * @return  io.streams.InputStream
     */
    public function getInputStream() {
      return $this->is;
    }

    /**
     * Returns an output stream for writing to this entry
     *
     * @return  io.streams.OutputStream
     */
    public function getOutputStream() {
      return $this->os;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s(%s)@{\n".
        "  [lastModified] %s\n".
        "}",
        $this->getClassName(),
        $this->name,
        xp::stringOf($this->mod)
      );
    }
  }
?>