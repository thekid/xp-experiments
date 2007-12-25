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
  class QuantMoveTask extends DirectoryBasedTask {
    public
      $file                 = NULL,
      $toFile               = NULL,
      $toDir                = NULL,
      $overwrite            = FALSE,
      $flatten              = FALSE,
      $includeEmptyDirs     = FALSE,
      $failOnError          = TRUE,
      $verbose              = FALSE,
      $preserveLastmodified = FALSE;
          
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@file')]
    public function setFile($f) {
      $this->file= $f;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@toFile')]
    public function setToFile($f) {
      $this->toFile= $f;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@toDir')]
    public function setToDir($d) {
      $this->toDir= $d;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@overwrite')]
    public function setOverwrite($o) {
      $this->overwrite= ($o == 'true');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@flatten')]
    public function setFlatten($f) {
      $this->flatten= ($f == 'true');
    }
    
    #[@xmlmapping(element= '@preservelastmodified')]
    public function setPreserveLastmodified($m) {
      $this->preserveLastmodified= ('true' == $m);
    }
    
    protected function copy(QuantEnvironment $env, $source, $target= NULL) {
      $s= new File($env->substitute($source));
      
      if (NULL === $target) {
        $target= $env->localUri($env->substitute($this->toDir.'/'.($this->flatten ? basename($source) : $source)));
      }
      $t= new File($target);
      
      // Only perform if target does not exist, or is outdated compared to
      // original, or overwrite mode is enabled.
      if (
        $t->exists() && 
        $t->lastModified()- $s->lastModified() < 2 &&
        !$this->overwrite
      ) return;

      if ($this->verbose) {
        $env->out->writeLine('===> Copy '.$s->getURI().' to '.$t->getURI());
      }
      
      $mtime= $s->lastModified();
      $s->move($t->getURI());
      
      if (TRUE === $this->preserveLastmodified) {
        $t->touch($mtime);
      }
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(QuantEnvironment $env) {
      if (NULL !== $this->file) {
        if (NULL === $this->toFile) throw new IllegalArgumentException('file given, but toFile is missing.');

        $this->copy($env, $this->file, $env->localUri($env->substitute($this->toFile)));
        return;
      }

      $iter= $this->fileset->iteratorFor($env);
      while ($iter->hasNext()) {
        $element= $iter->next();
        
        $this->copy($env, $element->relativePart());
      }
    }    
  }
?>
