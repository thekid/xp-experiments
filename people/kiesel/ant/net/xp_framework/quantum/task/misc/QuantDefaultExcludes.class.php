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
  class QuantDefaultexcludesTask extends QuantTask {
    protected
      $echo     = NULL,
      $default  = NULL,
      $add      = NULL,
      $remove   = NULL;

    #[@xmlmapping(element= '@echo')]
    public function setEcho() {
      $this->echo= TRUE;      
    }
    
    #[@xmlmapping(element= '@default')]
    public function setDefault() {
      $this->default= TRUE;
    }
    
    #[@xmlmapping(element= '@add')]
    public function setAdd($a) {
      $this->add= $a;
    }
    
    #[@xmlmapping(element= '@remove')]
    public function setRemove($r) {
      $this->remove= $r;
    }
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function execute() {
      if (TRUE === $this->echo) {
        $env->out->writeLine(implode(PHP_EOL, $this->env()->getDefaultExcludes()));
        return;
      }
      
      if (TRUE === $this->default) {
        $this->env()->initializeDefaultExcludes();
        return;
      }
      
      if (NULL !== $this->add) {
        $this->env()->addDefaultExclude($this->add);
        return;
      }
      
      if (NULL !== $this->remove) {
        $this->env()->removeDefaultExclude($this->remove);
        return;
      }
    }
  }
?>
