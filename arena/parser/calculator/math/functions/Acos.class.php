<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Arcus cosine
   *
   * @see      php://acos
   * @purpose  Function
   */
  class math·functions·Acos extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= acos($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
