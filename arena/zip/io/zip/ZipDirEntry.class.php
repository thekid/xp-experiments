<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.zip.ZipEntry');

  /**
   * Represents a Dir entry in a zip archive
   *
   * @see      xp://io.zip.ZipEntry
   * @purpose  Interface
   */
  class ZipDirEntry extends Object implements ZipEntry {
    protected 
      $name = '', 
      $mod  = NULL;
        
    /**
     * Constructor
     *
     * @param   string name
     * @param   util.Date modified default NULL
     */
    public function __construct($name, Date $modified= NULL) {
      $this->name= rtrim(str_replace('\\', '/', $name), '/').'/';
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
  }
?>
