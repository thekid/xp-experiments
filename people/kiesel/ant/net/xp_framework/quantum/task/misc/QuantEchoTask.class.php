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
  class QuantEchoTask extends QuantTask {
    protected
      $content  = NULL,
      $file     = NULL,
      $append   = FALSE,
      $level    = 'warning';

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
    
    #[@xmlmapping(element= '@message')]
    public function setMessage($message) {
      $this->content= trim($message);
    }
    
    #[@xmlmapping(element= '@file')]
    public function setFile($f) {
      $this->file= $f;
    }
    
    #[@xmlmapping(element= '@append')]
    public function setAppend($e) {
      $this->append= ('true' === $e);
    }
    
    #[@xmlmapping(element= '@level')]
    public function setLevel($l) {
      if (!in_array($l, array('error', 'warning', 'info', 'debug')))
        throw new IllegalArgumentException('Invalid level: "'.$l.'"');
        
      $this->level= $l;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function execute() {
      // TODO: Use level
      
      if ($this->file) {
        $f= new File($this->file, (TRUE === $this->append ? 'a' : 'w'));
        $f->write($this->valueOf($this->content));
        $f->close();
        return;
      }
      
      $this->env()->out->writeLine($this->valueOf($this->content));
    }    
  }
?>
