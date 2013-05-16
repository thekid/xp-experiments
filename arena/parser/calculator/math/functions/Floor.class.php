<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Round fractions down.
   *
   * @see      php://floor
   * @purpose  Function
   */
  class math·functions·Floor extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      return floor($arg);
    }
  }
?>
