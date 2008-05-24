<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Arcus sine
   *
   * @see      php://asin
   * @purpose  Function
   */
  class math·functions·Asin extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= asin($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
