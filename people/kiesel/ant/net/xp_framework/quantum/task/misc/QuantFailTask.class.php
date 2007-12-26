<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.task.QuantTask',
    'net.xp_framework.quantum.QuantBuildException'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantFailTask extends QuantTask {
    protected
      $message  = NULL,
      $if       = NULL,
      $unless   = NULL,
      $status   = NULL;

    #[@xmlmapping(element= '@message')]
    public function setMessage($m) {
      $this->message= $m;
    }
    
    #[@xmlmapping(element= '.')]
    public function setContent($m) {
      $this->message= trim($m);
    }
    
    #[@xmlmapping(element= '@if')]
    public function setIf($if) {
      $this->if= $if;
    }
    
    #[@xmlmapping(element= '@unless')]
    public function setUnless($u) {
      $this->unless= $u;
    }
    
    #[@xmlmapping(element= '@status')]
    public function setStatus($s) {
      $this->status= $status;
    }
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute() {
      if (NULL !== $this->if && !$this->env()->exists($this->if)) return;
      if (NULL !== $this->unless && $this->env()->exists($this->unless)) return;
      
      throw new QuantBuildException($this->valueOf($this->message), $this->status);
    }
  }
?>
