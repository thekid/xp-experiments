<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Find highest value
   *
   * @see      php://max
   * @purpose  Function
   */
  class math·functions·Max extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   mixed* args
     * @return  mixed
     */
    public static function calculate() {
      $a= func_get_args();
      return max($a);
    }
  }
?>
