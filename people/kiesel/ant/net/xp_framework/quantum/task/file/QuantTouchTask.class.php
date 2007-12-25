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
  class QuantTouchTask extends DirectoryBasedTask {
    public
      $file     = NULL,
      $datetime = NULL,
      $mkdirs   = FALSE,
      $verbose  = TRUE;
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@file')]
    public function setFile($file) {
      $this->file= $file;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@datetime')]
    public function setDatetime($time) {
      $this->datetime= new Date($time);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@mkdirs')]
    public function setMkdirs($mkdirs) {
      $this->mkdirs= ($mkdirs == 'true');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(QuantEnvironment $env) {
      if (!$this->datetime) $this->datetime= Date::now();

      if (NULL !== $this->file) {
        $f= new File($this->file);
        $f->touch($this->datetime->getTime());
        
        return;
      }
      
      $iterator= $this->iteratorForFileset($env);
      while ($iterator->hasNext()) {
        $entry= $iterator->next();
        
        // TODO: Implement FileSet touching
      }
    }
  }
?>
