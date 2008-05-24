<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Natural logarithm (ln)
   *
   * @see      php://log
   * @purpose  Function
   */
  class math·functions·Ln extends math·functions·Function {
    
    /**
     * Calculate the logarithm
     *
     * @param   float arg The value to calculate the logarithm for 
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= log($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
