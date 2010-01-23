<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'inject';

  /**
   * Represents a binding
   *
   */
  class inject·Binding extends Object {
    public $impl= NULL;
    public $instance= NULL;
   
    /**
     * Sets implementation
     *
     * @param   lang.XPClass impl
     * @return  inject.Binding this
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
     * @return  inject.Binding this
     */
    public function toInstance(Generic $instance) {
      $this->instance= $instance;
      $this->impl= NULL;
      return $this;
    }
    
    /**
     * Creates a string representation of this binding
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.($this->impl ? $this->impl->toString() : $this->instance->toString()).')';
    }
  }
?>
