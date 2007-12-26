<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.quantum.task.QuantTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantDirnameTask extends QuantTask {
    public
      $file     = NULL,
      $property = NULL;

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
     * Set property
     *
     * @param   lang.Object property
     */
    #[@xmlmapping(element= '@property')]
    public function setProperty($property) {
      $this->property= $property;
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute() {
      if (!$this->property || !$this->file)
        throw new IllegalArgumentException('Dirname must have property and file attribute');
      
      $env->put($this->property, dirname($this->valueOf($this->file)));
    }
  }
?>
