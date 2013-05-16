<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Return number of values
   *
   * @purpose  Function
   */
  class math·functions·Count extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   mixed* args
     * @return  mixed
     */
    public static function calculate() {
      return func_num_args();
    }
  }
?>
