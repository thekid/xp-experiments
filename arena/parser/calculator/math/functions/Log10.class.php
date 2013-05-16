<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Base-10 logarithm
   *
   * @see      php://log10
   * @purpose  Function
   */
  class math·functions·Log10 extends math·functions·Function {
    
    /**
     * Calculate the logarithm
     *
     * @param   float arg The value to calculate the logarithm for 
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= log10($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
