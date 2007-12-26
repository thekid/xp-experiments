<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.task.QuantTask',
    'io.Folder'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantMkdirTask extends QuantTask {
    public
      $dir    = NULL;
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@dir')]
    public function setDir($dir) {
      $this->dir= $dir;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute() {
      $folder= new Folder($this->uriOf($this->dir));
      if (!$folder->exists()) $folder->create();
    }
  }
?>
