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
     * @return  xml.xdom.Element  
     */
    public function getParent() {
      return $this->parent;
    }
  }
?>
