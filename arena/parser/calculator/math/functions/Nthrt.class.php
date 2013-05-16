<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.functions.Function');

  /**
   * Nth root
   *
   * @see      http://en.wikipedia.org/wiki/Nth_root
   * @see      php://pow
   * @purpose  Function
   */
  class math·functions·Nthrt extends math·functions·Function {
    
    /**
     * Calculate the nth root
     *
     * @param   int n 
     * @param   float number
     * @return  float
     */
    public static function calculate($n, $number) {
      if (FALSE !== ($l= pow($number, 1 / $n))) return $l;
      self::raiseError(__FILE__, __LINE__ - 1);
    }
  }
?>
