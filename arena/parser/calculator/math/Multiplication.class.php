<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';

  uses('math.Operation');

  /**
   * Multiplication
   *
   * @purpose  Operation implementation
   */
  class math·Multiplication extends math·Operation {

    /**
     * Perform this operation
     *
     * @param   math.Real lhs
     * @param   math.Real rhs
     * @return  math.Real
     */
    protected function perform(Real $lhs, Real $rhs) {
      if ($lhs instanceof Rational && $rhs instanceof Rational) {
        $r= new Rational();
        $r->numerator= $lhs->numerator * $rhs->numerator;
        $r->denominator= $lhs->denominator * $rhs->denominator;
        return $r;
      }
      return new Real($lhs->asNumber() * $rhs->asNumber());
    }
  }
?>
