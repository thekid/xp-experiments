<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.FileUtil', 'io.File');

  /**
   * Represents an import
   *
   * @see      xp://net.xp_framework.quantum.QuantProject#importBuildfile
   * @purpose  Value Object
   */
  class QuantImport extends Object {
    protected
      $file= NULL;

    /**
     * (Insert method's description here)
     *
     * @param   string file
     */
    #[@xmlmapping(element= '@file')]
    public function setFile($file) {
      $this->file= $file;
    }
    
    /**
     * Resolve this import
     *
     * @param   string dirname
     * @return  net.xp_framework.quantum.QuantProject
     */
    public function resolve($dirname) {
      if ('/' === $this->file{0}) {
        $f= new File($this->file);    // Absolute path
      } else {
        $f= new File($dirname.DIRECTORY_SEPARATOR.$this->file);
      }
      return QuantProject::fromString(FileUtil::getContents($f), $f->getURI());
    }
  }
?>
