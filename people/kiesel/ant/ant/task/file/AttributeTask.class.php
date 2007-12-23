<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'ant.task.DirectoryBasedTask'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AttributeTask extends DirectoryBasedTask {
    protected
      $file     = NULL,
      $type     = 'file',
      $verbose  = FALSE,
      $stats    = array('file' => 0, 'dir' => 0);
      
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
    
    #[@xmlmapping(element= '@type')]
    public function setType($t) {
      if (!in_array($t, array('file', 'dir', 'both')))
        throw new IllegalArgumentException('Cannot set <chgrp> type to '.$t.', must be one of "file", "dir", "both"');
      
      $this->t= $t;
    }
    
    protected function perform($env, $uri) {
      $name= $env->localUri($env->substitute($uri));

      // TODO: Refactor, so we can select dirs and files by fileset already
      if (is_file($name)) {
        if ('dir' === $this->type) return;
        $this->stats['file']++;
      } else if (is_dir($name)) {
        if ('file' === $this->type) return;
        $this->stats['dir']++;
      } else {
        
        // TBD: Is this an error?
        // Element does not exist?!
        throw new IllegalArgumentException('Cannot chgroup of inexistant element '.$name);
      }
      
      return $name;
    }
    
    protected abstract function writeStats();
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(AntEnvironment $env) {
      if (NULL !== $this->file) {
        $this->_perform($env, $this->file);
      } else {
        $iter= $this->fileset->iteratorFor($env);

        while ($iter->hasNext()) {
          $element= $iter->next();
          
          $this->_perform($env, $element->getURI());
        }
      }
      
      $this->verbose && $this->writeStats($env);
    }
  }
?>
