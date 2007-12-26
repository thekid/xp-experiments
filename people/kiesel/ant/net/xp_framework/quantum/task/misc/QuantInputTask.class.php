<?php
/* This class is part of the XP framework
 *
 * $Id: QuantEchoTask.class.php 8846 2007-04-14 18:46:50Z kiesel $ 
 */

  uses('net.xp_framework.quantum.task.QuantTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantInputTask extends QuantTask {
    protected
      $message      = NULL,
      $validArgs    = NULL,
      $addProperty  = NULL,
      $defaultValue = NULL;
      
    #[@xmlmapping(element= '@message')]
    public function setMessage($m) {
      $this->message= $m;
    }
    
    #[@xmlmapping(element= '@validargs')]
    public function setValidArgs($v) {
      $this->validArgs= explode(',', $v);      
    }
    
    #[@xmlmapping(element= '@addproperty')]
    public function setAddProperty($p) {
      $this->addProperty= $p;
    }
    
    #[@xmlmapping(element= '@defaultValue')]
    public function setDefaultvalue($d) {
      $this->defaultValue= $d;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function execute() {
      while (TRUE) {
        $this->env()->out->writeLine($this->valueOf($this->message));
        $input= trim($this->env()->in->readLine());
      
        if (!is_array($this->validArgs)) break;
        if (in_array($input, $this->validArgs)) break;
      }
      
      if (NULL !== $this->addProperty) {
        $this->env()->put($this->addProperty, $input ? $input : $this->defaultValue);
      }
    }    
  }
?>
