<?php
/* This class is part of the XP framework
 *
 * $Id: AntEchoTask.class.php 8846 2007-04-14 18:46:50Z kiesel $ 
 */

  uses('ant.task.AntTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AntInputTask extends AntTask {
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
    public function execute(AntEnvironment $env) {
      while (TRUE) {
        $env->out->writeLine($env->substitute($this->message));
        $input= trim($env->in->readLine());
      
        if (!is_array($this->validArgs)) break;
        if (in_array($input, $this->validArgs)) break;
      }
      
      if (NULL !== $this->addProperty) {
        $env->put($this->addProperty, $input ? $input : $this->defaultValue);
      }
    }    
  }
?>
