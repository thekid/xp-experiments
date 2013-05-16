<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests';
  
  /**
   * Used by ExtensionMethodPerformance profiler
   *
   */
  class tests·GenericExtension extends Object {

    static function __static() {
      xp::extensions('lang.Generic', __CLASS__);
    }

    /**
     * Extension method
     *
     * @param   Generic self
     * @param   int i
     */
    public static function gen(Generic $self, $i) {
      return $i--;
    }
  }
?>
