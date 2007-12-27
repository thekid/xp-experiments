<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.diff.operation.AbstractOperation');

  /**
   * (Insert class' description here)
   *
   * @see      xp://text.diff.operation.AbstractOperation
   * @purpose  purpose
   */
  class Change extends AbstractOperation {
    public
      $newText= NULL;
    
    public function __construct($oldText, $newText) {
      parent::__construct($oldText);
      $this->newText= $newText;
    }

    public function equals($cmp) {
      return 
        $cmp instanceof self && 
        $cmp->text === $this->text && 
        $cmp->newText === $this->newText
      ;
    }  
  }
?>
