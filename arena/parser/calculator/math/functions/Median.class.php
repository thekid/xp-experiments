<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Find median value
   *
   * @purpose  Function
   */
  class math·functions·Median extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   mixed* args
     * @return  mixed
     */
    public static function calculate() {
      $values= func_get_args();
      sort($values);
      if (sizeof($values) % 2 != 0) return $values[((sizeof($values)+ 1) / 2)- 1];
      return 0.5 * (
        $values[intval(sizeof($values) / 2)- 1] +
        $values[intval(sizeof($values) / 2)]
      );            
    }
  }
?>
