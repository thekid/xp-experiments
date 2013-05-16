<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Calculates the exponent (exp)
   *
   * @see      php://exp
   * @purpose  Function
   */
  class math·functions·Exp extends math·functions·Function {
    
    /**
     * Calculate the exponent
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= exp($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
