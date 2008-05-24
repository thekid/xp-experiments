<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Sine
   *
   * @see      php://sin
   * @purpose  Function
   */
  class math·functions·Sin extends math·functions·Function {
    
    /**
     * Calculate the sine
     *
     * @param   float arg in radians
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= sin($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
