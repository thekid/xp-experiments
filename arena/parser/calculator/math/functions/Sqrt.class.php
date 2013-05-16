<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Square root
   *
   * @see      php://sqrt
   * @see      http://en.wikipedia.org/wiki/Square_root
   * @purpose  Function
   */
  class math·functions·Sqrt extends math·functions·Function {
    
    /**
     * Calculate the square root
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      return sqrt($arg);
    }
  }
?>
