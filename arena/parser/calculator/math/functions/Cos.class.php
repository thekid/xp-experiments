<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Cosine
   *
   * @see      php://cos
   * @purpose  Function
   */
  class math·functions·Cos extends math·functions·Function {
    
    /**
     * Calculate the cosine
     *
     * @param   float arg in radians
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= cos($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
