<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Arcus tangent
   *
   * @see      php://atan
   * @purpose  Function
   */
  class math·functions·Atan extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= atan($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
