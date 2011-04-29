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
     * Get parent element
     *
     * @return  xml.xdom.Element  
     */
    public function getParent() {
      return $this->parent;
    }

    /**
     * Set parent element
     *
     * @param   xml.xdom.Element parent
     */
    public function setParent(Element $parent) {
      $this->parent= $parent;
    }
  }
?>
