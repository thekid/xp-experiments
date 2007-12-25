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
  class QuantUnknownTask extends QuantTask {
    public
      $type     = '';

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '.', pass= array('name()'))]
    public function setType($type) {
      $this->type= $type;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function execute(QuantEnvironment $env) {
      raise('lang.MethodNotImplementedException', 'Unknown task "'.$this->type.'" invoked.');
    }    
  }
?>
