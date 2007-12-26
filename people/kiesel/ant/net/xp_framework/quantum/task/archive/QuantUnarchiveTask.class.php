<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.File', 'net.xp_framework.quantum.task.QuantTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  abstract class QuantUnarchiveTask extends QuantTask {
    protected
      $src          = NULL,
      $dest         = NULL,
      $overwrite    = TRUE,
      $compression  = NULL,
      $encoding     = NULL,
      $verbose      = FALSE,
      $patternset   = NULL;
    
    #[@xmlmapping(element= '@src')]
    public function setSrc($src) {
      $this->src= $src;
    }
    
    #[@xmlmapping(element= '@dest')]
    public function setDest($d) {
      $this->dest= $d;
    }
    
    #[@xmlmapping(element= '@overwrite')]
    public function setOverwrite($o) {
      $this->overwrite= ('true' === $o);
    }
    
    #[@xmlmapping(element= '@verbose')]
    public function setVerbose($v) {
      $this->verbose= ('true' === $v);
    }
    
    #[@xmlmapping(element= 'patternset', class= 'net.xp_framework.quantum.QuantPatternSet')]
    public function setPatternSet($p) {
      $this->patternset= $p;
    }
    
    protected function targetFilename($name) {
      // TBI: Implement mapper logic
      return $this->uriOf(($this->dest ? $this->dest.'/' : '')).$name;
    }
    
    protected function execute() {
      $arc= $this->open();
      
      while ($element= $this->nextElement($arc)) {
        
        // Prepare target name
        $elementName= $this->elementName($arc, $element);
        
        if ($this->patternset && !$this->patternset->evaluatePatternOn($elementName)) continue;
        $data= $this->extract($arc, $element);
       
        $f= new File($this->targetFilename($elementName));
        if ($f->exists() && !$this->overwrite) return;
        
        $this->verbose && $this->env()->out->writeLine('Extracting '.$elementName.' to '.$f->getURI());
        continue;
        
        $f->open(FILE_MODE_WRITE);
        $f->write($data);
        $f->close();
      }
      
      $this->close($arc);
    }

    protected abstract function open();
    protected abstract function nextElement($arc);
    protected abstract function elementName($arc, $element);
    protected abstract function extract($arc, $element);
    protected abstract function close($arc);
  }
?>
