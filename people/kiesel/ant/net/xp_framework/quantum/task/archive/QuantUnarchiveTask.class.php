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
    
    #[@xmlmapping(element= 'patternset', class= 'net.xp_framework.quantum.QuantPatternSet')]
    public function setPatternSet($p) {
      $this->patternset= $p;
    }
    
    protected function targetFilename($env, $name) {
      // TBI: Implement mapper logic
      return $env->localUri(($this->dest ? $this->dest.'/' : '').$name);
    }
    
    protected function execute(QuantEnvironment $env) {
      $arc= $this->open($env);
      
      while ($element= $this->nextElement($env, $arc)) {
        
        // TBI: Implement filtering logic
        $data= $this->extract($env, $arc, $element);
       
        // Prepare target name
        $elementName= $this->elementName($env, $arc, $element);
        $f= new File($this->targetFilename($env, $elementName));
        if ($f->exists() && !$this->overwrite) return;
        
        $env->out->writeLine('Extracting '.$elementName.' to '.$f->getURI());
        continue;
        
        $f->open(FILE_MODE_WRITE);
        $f->write($data);
        $f->close();
      }
      
      $this->close($env, $arc);
    }

    protected abstract function open($env);
    protected abstract function nextElement($env, $arc);
    protected abstract function elementName($env, $arc, $element);
    protected abstract function extract($env, $arc, $element);
    protected abstract function close($env, $arc);
  }
?>
