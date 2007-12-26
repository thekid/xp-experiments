<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'lang.archive.Archive',
    'net.xp_framework.quantum.task.archive.QuantUnarchiveTask');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantUnxarTask extends QuantUnarchiveTask {
    
    protected function open($env) {
      $arc= new Archive(new File($env->localUri($env->substitute($this->src))));
      $arc->open(ARCHIVE_READ);
      return $arc;
    }
    
    protected function nextElement($env, $arc) {
      return $arc->getEntry();
    }
    
    protected function elementName($env, $arc, $element) {
      return $element;
    }
    
    protected function extract($env, $arc, $element) {
      return $arc->extract($element);
    }
    
    protected function close($env, $arc) {
      $arc->close();
    }
  }
?>
