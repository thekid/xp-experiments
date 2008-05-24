<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Hyperbolic sine
   *
   * @see      php://sinh
   * @purpose  Function
   */
  class math·functions·sinh extends math·functions·Function {
    
    /**
     * Calculate the hyperbolic sine
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (FALSE !== ($l= sinh($arg))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
