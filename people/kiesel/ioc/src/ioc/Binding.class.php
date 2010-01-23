<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'ioc';

  /**
   * Represents a binding
   *
   */
  class ioc·Binding extends Object {
    public $impl= NULL;
   
    /**
     * Sets implementation
     *
     * @param   lang.XPClass impl
     */
    public function to(XPClass $impl) {
      $this->impl= $impl;
    }
  }
?>
