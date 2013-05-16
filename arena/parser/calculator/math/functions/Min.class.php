<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Find lowest value
   *
   * @see      php://min
   * @purpose  Function
   */
  class math·functions·Min extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   mixed* args
     * @return  mixed
     */
    public static function calculate() {
      $a= func_get_args();
      return min($a);
    }
  }
?>
