<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'ant.task.AntTask',
    'ant.AntBuildException'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AntFailTask extends AntTask {
    protected
      $message  = NULL,
      $if       = NULL,
      $unless   = NULL,
      $status   = NULL;

    #[@xmlmapping(element= '@message')]
    public setMessage($m) {
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
    protected function execute(AntEnvironment $env) {
      if (NULL !== $this->if && !$env->exists($this->if)) return;
      if (NULL !== $this->unless && $env->exists($this->unless)) return;
      
      throw new AntBuildException($this->substitute($this->message), $this->status);
    }
  }
?>
