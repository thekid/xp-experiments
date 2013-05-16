<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Calculates factorial
   *
   * @see      http://en.wikipedia.org/wiki/Factorial
   * @purpose  Function
   */
  class math·functions·Fac extends math·functions·Function {
    
    /**
     * Calculate
     *
     * @param   float arg
     * @return  float
     */
    public static function calculate($arg) {
      if (floor($arg) != $arg) {
        throw new EvaluationError('Factorial not defined for non-integers');
      }
      
      // Calculate factorial without recursion
      for ($i= 1, $n= 1; $i < $arg+ 1; $i++) { $n*= $i; }
      return $n;
    }
  }
?>
