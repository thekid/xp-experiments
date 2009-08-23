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
  class tests·ObjectExtension extends Object {

    static function __static() {
      xp::extensions('lang.Object', __CLASS__);
    }

    /**
     * Extension method
     *
     * @param   Object self
     * @param   int i
     */
    public static function obj(Object $self, $i) {
      return $i--;
    }
  }
?>
