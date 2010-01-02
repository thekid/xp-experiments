<?php
/* This class is part of the XP framework
 *
 * $Id: ZipEntry.class.php 11840 2010-01-02 13:58:25Z friebe $ 
 */

  uses('util.Date');

  /**
   * Represents an entry in a zip archive
   *
   * @see      xp://io.archive.zip.ZipArchive
   * @purpose  Interface
   */
  interface ZipEntry {
    
    /**
     * Gets a zip entry's name
     *
     * @return  string
     */
    public function getName();

    /**
     * Gets a zip entry's last modification time
     *
     * @return  util.Date
     */
    public function lastModified();

    /**
     * Returns whether this entry is a directory
     *
     * @return  bool
     */
    public function isDirectory();
  }
?>
