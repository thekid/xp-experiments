<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Rounds value (3.4 = 3, 3.5 = 4)
   *
   * @see      php://round
   * @purpose  Function
   */
  class math·functions·Round extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      return round($arg);
    }
  }
?>
