<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.diff.operation.AbstractOperation');

  /**
   * Indicates a change (basically, a deletion and an insertion right
   * thereafter)
   *
   * @see      xp://text.diff.operation.AbstractOperation
   * @purpose  Value object
   */
  class Change extends AbstractOperation {
    public
      $newText= NULL;
    
    /**
     * Constructor
     *
     * @param   string text
     * @param   string newText
     */
    public function __construct($oldText, $newText) {
      parent::__construct($oldText);
      $this->newText= $newText;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'{"'.$this->text.'" -> "'.$this->newText.'"}';
    }

    /**
     * Returns whether another object is equal to this object
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return 
        $cmp instanceof self && 
        $cmp->text === $this->text && 
        $cmp->newText === $this->newText
      ;
    }  
  }
?>
