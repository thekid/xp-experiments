<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Logarithm (log)
   *
   * @see      php://log
   * @purpose  Function
   */
  class math·functions·Log extends math·functions·Function {
    
    /**
     * Calculate the logarithm
     *
     * @param   float arg The value to calculate the logarithm for 
     * @param   float base The logarithmic base to use 
     * @return  float
     */
    public static function calculate($arg, $base) {
      if (FALSE !== ($l= log($arg, $base))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
