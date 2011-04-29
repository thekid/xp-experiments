<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Edit operation
   *
   * @purpose  Abstract base class
   */
  abstract class AbstractOperation extends Object {
    public
      $text= NULL;
    
    /**
     * Constructor
     *
     * @param   string text
     */
    public function __construct($text) {
      $this->text= $text;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'{"'.$this->text.'"}';
    }

    /**
     * Returns whether another object is equal to this object
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && $cmp->text === $this->text;
    }
  }
?>
