<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Calculates absolute value
   *
   * @see      php://abs
   * @purpose  Function
   */
  class math·functions·Abs extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      return abs($arg);
    }
  }
?>
