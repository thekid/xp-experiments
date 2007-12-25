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
  class QuantPropertyTask extends QuantTask {
    public
      $name     = '',
      $value    = '';
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@name')]
    public function setName($name) {
      $this->name= $name;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@value')]
    public function setValue($value) {
      $this->value= $value;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(QuantEnvironment $env) {
      // Properties may be declared twice, first occurrence wins
      if ($env->exists($this->name)) return;
      $env->put($this->name, $env->substitute($this->value));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      return $this->getClassName().'@('.$this->hashCode().') { '.$this->name.'= '.$this->value.' }';
    }    
  }
?>
