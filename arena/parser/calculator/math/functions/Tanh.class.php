<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Hyperbolic tangent
   *
   * @see      php://tanh
   * @purpose  Function
   */
  class math·functions·Tanh extends math·functions·Function {
    
    /**
     * Calculate the hyperbolic tangent
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= tanh($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
