<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'inject';
  
  /**
   * Represents a module
   *
   */
  interface inject·Module {

    /**
     * Resolves a class
     *
     * @param   lang.XPClass class
     * @return  inject.Binding
     */
    public function resolve(XPClass $class);
  }
?>
