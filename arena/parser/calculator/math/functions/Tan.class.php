<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Tangent
   *
   * @see      php://tan
   * @purpose  Function
   */
  class math·functions·Tan extends math·functions·Function {
    
    /**
     * Calculate the tangent
     *
     * @param   float arg in radians
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= tan($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
