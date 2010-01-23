<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'inject.Injector',
    'inject.Module'
  );

  /**
   * IOC injector entry point
   *
   */
  class IoC extends Object {

    /**
     * Creates a new injector for a given module
     *
     * @param   inject.Module module
     * @return  inject.Injector
     */
    public static function getInjectorFor(inject·Module $module) {
      return new inject·Injector($module);
    }
  }
?>
