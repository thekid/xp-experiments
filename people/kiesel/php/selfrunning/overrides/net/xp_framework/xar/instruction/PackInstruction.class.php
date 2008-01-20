<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.xar.instruction.AbstractInstruction');
    
  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class PackInstruction extends AbstractInstruction {
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function perform() {
      $target= array_shift($this->args);
      $target= (strlen($target)
        ? $target
        : basename($this->archive->getURI(), '.xar').'.sxar'
      ); 
      
      if ($this->options & Xar::OPTION_VERBOSE) {
        $this->out->writeLine('---> Source XAR: '.$this->archive->getURI());
        $this->out->writeLine('---> Target SXAR: '.$target);
      }
      
      // Load lang.base.php
      $ldr= ClassLoader::getDefault()->findResource('lang.base.php');
      $this->options & Xar::OPTION_VERBOSE && $this->out->writeLine('---> using lang.base.php provided by: ', $ldr);
      
      // Open source and destionation files
      $src= new File($this->archive->getURI());
      $src->open(FILE_MODE_READ);
      
      $dest= new File($target);
      $dest->open(FILE_MODE_WRITE);
      
      // Write out lang.base.php to target XAR
      $dest->write($ldr->getResource('lang.base.php'));
      
      // then write out contents of source XAR
      $dest->write(FileUtil::getContents($src));
    }
  }
?>
