<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  
  uses('ant.task.DirectoryBasedTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AntDeleteTask extends DirectoryBasedTask {
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
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getFile(AntEnvironment $env) {
      return $env->localUri($env->substitute($this->file));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getDir(AntEnvironment $env) {
      return $env->localUri($env->substitute($this->dir));
    }
    
    protected function delete($env, $file) {
      $f= new File($env->localUri($env->substitute($file)));
      $this->verbose && $env->out->writeLine('Deleting '.$file);
      if (!$f->exists()) return;

      try {
        $f->unlink();
      } catch (IOException $e) {
        if ($this->failOnError) throw $e;
        $this->quiet || $env->err->writeLine('Could not delete file '.$f->getURI().': '.$e->getMessage());
      }
    }
    
    protected function deleteFolder($env, $folder) {
      $this->verbose && $env->out->writeLine('Deleting folder '.$folder);
      $f= new Folder($env->localUri($env->substitute($this->dir)));
      if ($f->exists()) return;

      try {
        $f->unlink();
      } catch (IOException $e) {
        if ($this->failOnError) throw $e;
        $this->quiet || $env->err->writeLine('Could not delete folder '.$f->getURI().': '.$e->getMessage());
      }
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(AntEnvironment $env) {
      if (NULL !== $this->file) {
        $this->delete($env, $this->file);
        return;
      }
      
      if (NULL !== $this->dir) {
        $this->deleteFolder($env, $this->dir);
        return;
      }
      
      if (NULL !== $this->fileset) {
        $iter= $this->fileset->iteratorFor($env);
        while ($iter->hasNext()) {
          $element= $iter->next();

          $this->delete($env, $element->relativePart());
        }
      }
    }
  }
?>
