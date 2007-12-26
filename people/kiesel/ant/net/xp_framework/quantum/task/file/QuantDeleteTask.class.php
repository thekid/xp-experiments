<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  
  uses('net.xp_framework.quantum.task.DirectoryBasedTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantDeleteTask extends DirectoryBasedTask {
    public
      $file             = NULL, 
      $dir              = NULL, 
      $verbose          = FALSE,
      $quiet            = FALSE,
      $failOnError      = TRUE,
      $includeEmptyDirs = FALSE;

    /**
     * Set file
     *
     * @param   lang.Object file
     */
    #[@xmlmapping(element= '@file')]
    public function setFile($file) {
      $this->file= $file;
    }

    /**
     * Set dir
     *
     * @param   lang.Object dir
     */
    #[@xmlmapping(element= '@dir')]
    public function setDir($dir) {
      $this->dir= $dir;
    }

    /**
     * Set verbose
     *
     * @param   bool verbose
     */
    #[@xmlmapping(element= '@verbose')]
    public function setVerbose($verbose) {
      $this->verbose= ('true' == $verbose);
    }
    
    /**
     * Set quiet
     *
     * @param   bool quiet
     */
    #[@xmlmapping(element= '@quiet')]
    public function setQuiet($quiet) {
      $this->quiet= $quiet;
    }

    /**
     * Set failOnError
     *
     * @param   bool failOnError
     */
    #[@xmlmapping(element= '@failonerror')]
    public function setFailOnError($failOnError) {
      $this->failOnError= $failOnError;
    }

    /**
     * Set includeEmptyDirs
     *
     * @param   bool includeEmptyDirs
     */
    #[@xmlmapping(element= '@includeemptydirs')]
    public function setIncludeEmptyDirs($includeEmptyDirs) {
      $this->includeEmptyDirs= $includeEmptyDirs;
    }
    
    protected function delete($file) {
      $f= new File($this->uriOf($file));
      $this->verbose && $this->env()->out->writeLine('Deleting '.$file);
      if (!$f->exists()) return;

      try {
        $f->unlink();
      } catch (IOException $e) {
        if ($this->failOnError) throw $e;
        $this->quiet || $this->env()->err->writeLine('Could not delete file '.$f->getURI().': '.$e->getMessage());
      }
    }
    
    protected function deleteFolder($folder) {
      $this->verbose && $this->env()->out->writeLine('Deleting folder '.$folder);
      $f= new Folder($this->valueOf($this->dir));
      if ($f->exists()) return;

      try {
        $f->unlink();
      } catch (IOException $e) {
        if ($this->failOnError) throw $e;
        $this->quiet || $this->env()->err->writeLine('Could not delete folder '.$f->getURI().': '.$e->getMessage());
      }
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute() {
      if (NULL !== $this->file) {
        $this->delete($this->file);
        return;
      }
      
      if (NULL !== $this->dir) {
        $this->deleteFolder($this->dir);
        return;
      }
      
      if (NULL !== $this->fileset) {
        $iter= $this->fileset->iteratorFor($env);
        while ($iter->hasNext()) {
          $element= $iter->next();

          $this->delete($element->relativePath());
        }
      }
    }
  }
?>
