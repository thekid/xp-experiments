<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'ioc';
  
  /**
   * Represents a module
   *
   */
  interface ioc·Module {

    /**
     * Resolves a class
     *
     * @param   lang.XPClass class
     * @return  ioc.Binding
     */
    public function resolve(XPClass $class);
  }
?>
