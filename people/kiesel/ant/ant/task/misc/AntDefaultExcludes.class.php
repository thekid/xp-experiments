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
  class AntDefaultexcludesTask extends AntTask {
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
    public function execute(AntEnvironment $env) {
      if (TRUE === $this->echo) {
        $env->out->writeLine(implode(PHP_EOL, $env->getDefaultExcludes()));
        return;
      }
      
      if (TRUE === $this->default) {
        $env->initializeDefaultExcludes();
        return;
      }
      
      if (NULL !== $this->add) {
        $env->addDefaultExclude($this->add);
        return;
      }
      
      if (NULL !== $this->remove) {
        $env->removeDefaultExclude($this->remove);
        return;
      }
    }
  }
?>
