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
   
    public function to($impl) {
      $this->impl= $impl;
    }
  }
?>
