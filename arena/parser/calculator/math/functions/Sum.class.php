<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Return sum of values
   *
   * @see      php://avg
   * @purpose  Function
   */
  class math·functions·Sum extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   mixed* args
     * @return  mixed
     */
    public static function calculate() {
      $a= func_get_args();
      return array_sum($a);
    }
  }
?>
