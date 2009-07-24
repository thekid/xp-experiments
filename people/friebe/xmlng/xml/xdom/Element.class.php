<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   */
  abstract class Element extends Object {
    public $parent= NULL;

    /**
     * (Insert method's description here)
     *
     * @param   
     */
    public function getParent() {
      return $this->parent;
    }
  }
?>
