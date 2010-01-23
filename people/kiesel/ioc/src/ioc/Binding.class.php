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
    public $instance= NULL;
   
    /**
     * Sets implementation
     *
     * @param   lang.XPClass impl
     * @return  ioc.Binding this
     */
    public function to(XPClass $impl) {
      $this->impl= $impl;
      $this->instance= NULL;
      return $this;
    }

    /**
     * Sets instance
     *
     * @param   lang.Generic instance
     * @return  ioc.Binding this
     */
    public function toInstance(Generic $instance) {
      $this->instance= $instance;
      $this->impl= NULL;
      return $this;
    }
  }
?>
