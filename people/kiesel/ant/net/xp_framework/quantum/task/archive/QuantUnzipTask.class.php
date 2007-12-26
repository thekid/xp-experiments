<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.quantum.task.archive.QuantUnarchiveTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantUnzipTask extends QuantUnarchiveTask {
    
    protected function open() {
      $arc= new ZipArchive();
      if (FALSE === $arc->open($this->uriOf($this->src)))
        throw new IOException('Could not open archive '.$uri);
      
      $this->ptr= 0;
        
      return $arc;
    }
    
    protected function nextElement($arc) {
      if ($this->ptr == $arc->numFiles) return NULL;
      
      return $arc->statIndex($this->ptr++);
    }
    
    protected function elementName($arc, $element) {
      return $element['name'];
    }
    
    protected function extract($arc, $element) {
      $data= $arc->getFromIndex($element['index']);
      if (FALSE === $data)
        throw new IOException('Could not read entry '.$element['name']);
      
      return $data;
    }
    
    protected function close($arc) {
      $arc->close();
    }
  }
?>
