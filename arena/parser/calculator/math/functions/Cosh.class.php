<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Hyperbolic cosine
   *
   * @see      php://cosh
   * @purpose  Function
   */
  class math·functions·Cosh extends math·functions·Function {
    
    /**
     * Calculate the hyperbolic cosine
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= cosh($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
