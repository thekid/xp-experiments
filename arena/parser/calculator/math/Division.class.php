<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';

  uses('math.Operation');

  /**
   * Division
   *
   * @purpose  Operation implementation
   */
  class math·Division extends math·Operation {

    /**
     * Perform this operation
     *
     * @param   math.Real lhs
     * @param   math.Real rhs
     * @return  math.Real
     */
    protected function perform(Real $lhs, Real $rhs) {
      if ($rhs->equals(Real::$ZERO)) {
        throw new IllegalArgumentException('Division by zero');
      }

      if ($lhs instanceof Rational && $rhs instanceof Rational) {
        $r= new Rational();
        $r->numerator= $lhs->numerator * $rhs->denominator;
        $r->denominator= $lhs->denominator * $rhs->numerator;

        // -1/-2 => 1/2
        if ($r->numerator < 0 && $r->denominator < 0) {
          $r->numerator*= -1;
          $r->denominator*= -1;
        }
        return $r;
      }
      return new Real($lhs->asNumber() / $rhs->asNumber());
    }
  }
?>
