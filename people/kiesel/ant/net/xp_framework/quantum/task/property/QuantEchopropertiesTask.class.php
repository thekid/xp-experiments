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
  class QuantEchopropertiesTask extends QuantTask {
    protected
      $destfile     = NULL,
      $prefix       = NULL,
      $regex        = NULL,
      $failOnError  = FALSE,
      $format       = 'text';
    
    #[@xmlmapping(element= '@destfile')]
    public function setDestfile($d) {
      $this->destfile= $d;
    }
    
    #[@xmlmapping(element= '@prefix')]
    public function setPrefix($p) {
      $this->prefix= $p;
    }
    
    #[@xmlmapping(element= '@regex')]
    public function setRegex($r) {
      $this->regex= $r;
    }
    
    #[@xmlmapping(element= '@failonerror')]
    public function setFailOnError($e) {
      $this->failOnError= ('true' === $e);
    }
    
    #[@xmlmapping(element= '@format')]
    public function setFormat($f) {
      if (!in_array($f, array('text', 'xml')))
        throw new IllegalArgumentException('Invalid format given: "'.$f.'"');
      
      $this->format= $f;
    }
    
    protected function execute() {
      // TODO: Implement writing to file +failonerror handling
      // TODO: Implement XML output
      
      $this->env()->resetPointer();
      while (NULL !== ($value= $this->env()->nextProperty())) {
        list ($key, $val)= $value;
        
        if ($this->prefix && 0 !== strncmp($key, $this->prefix, strlen($this->prefix))) continue;
        if ($this->regex && !preg_match('#'.preg_quote($this->regex, '#').'#', $key)) continue;
        
        switch ($this->format) {
          case 'text': {
            $this->env()->out->writeLine($key.': '.$val);
            break;
          }
        }
      }
    }
  }
?>
