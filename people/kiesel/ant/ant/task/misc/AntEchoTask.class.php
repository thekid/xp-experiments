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
  class AntEchoTask extends AntTask {
    public
      $content= '';

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '.')]
    public function setContent($content) {
      $this->content= trim($content);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function execute(AntEnvironment $env) {
      $env->out->writeLine($env->substitute($this->content));
    }    
  }
?>
