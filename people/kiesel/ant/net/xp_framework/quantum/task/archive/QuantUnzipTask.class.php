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
    
    protected function open($env) {
      $arc= new ZipArchive();
      if (FALSE === $arc->open($env->localUri($env->substitute($this->src))))
        throw new IOException('Could not open archive '.$uri);
      
      $this->ptr= 0;
        
      return $arc;
    }
    
    protected function nextElement($env, $arc) {
      if ($this->ptr == $arc->numFiles) return NULL;
      
      return $arc->statIndex($this->ptr++);
    }
    
    protected function elementName($env, $arc, $element) {
      return $element['name'];
    }
    
    protected function extract($env, $arc, $element) {
      $data= $arc->getFromIndex($element['index']);
      if (FALSE === $data)
        throw new IOException('Could not read entry '.$element['name']);
      
      return $data;
    }
    
    protected function close($env, $arc) {
      $arc->close();
    }
  }
?>
