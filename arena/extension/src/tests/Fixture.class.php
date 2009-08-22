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
  class tests·Fixture extends Object {
    
    /**
     * Instance method
     *
     * @param   int i
     */
    public function inc($i) {
      return $i++;
    }
  }
?>
