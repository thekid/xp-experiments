<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'ioc.Injector',
    'ioc.Module'
  );

  /**
   * IOC injector entry point
   *
   */
  class IoC extends Object {

    /**
     * Creates a new injector for a given module
     *
     * @param   ioc.Module module
     * @return  ioc.Injector
     */
    public static function getInjectorFor(ioc·Module $module) {
      return new ioc·Injector($module);
    }
  }
?>
