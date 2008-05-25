<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math';

  uses('math.Operation');

  /**
   * Power
   *
   * @see      php://pow
   * @purpose  Operation implementation
   */
  class math·Power extends math·Operation {

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
        $r->numerator= pow($lhs->numerator, $rhs->asNumber());
        $r->denominator= pow($lhs->denominator, $rhs->asNumber());
        return $r;
      }
      return new Real(pow($lhs->asNumber(), $rhs->asNumber()));
    }
  }
?>
