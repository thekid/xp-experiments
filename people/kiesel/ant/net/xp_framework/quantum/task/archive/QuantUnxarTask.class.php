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
    
    protected function open() {
      $arc= new Archive(new File($this->uriOf($this->src)));
      $arc->open(ARCHIVE_READ);
      return $arc;
    }
    
    protected function nextElement($arc) {
      return $arc->getEntry();
    }
    
    protected function elementName($arc, $element) {
      return $element;
    }
    
    protected function extract($arc, $element) {
      return $arc->extract($element);
    }
    
    protected function close($arc) {
      $arc->close();
    }
  }
?>
