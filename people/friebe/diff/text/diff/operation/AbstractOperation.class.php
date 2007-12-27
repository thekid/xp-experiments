<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  abstract class AbstractOperation extends Object {
    public
      $text= NULL;
    
    public function __construct($text) {
      $this->text= $text;
    }

    public function equals($cmp) {
      return $cmp instanceof self && $cmp->text === $this->text;
    }
  }
?>
