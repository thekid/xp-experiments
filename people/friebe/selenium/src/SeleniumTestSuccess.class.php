<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('SeleniumTestResult');

  /**
   * (Insert class' description here)
   *
   */
  class SeleniumTestSuccess extends SeleniumTestResult {
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->name.'>';
    }
  }
?>
