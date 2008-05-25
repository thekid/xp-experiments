<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math';

  uses('math.Operation');

  /**
   * Modulo
   *
   * @purpose  Operation implementation
   */
  class math·Modulo extends math·Operation {

    /**
     * Perform this operation
     *
     * @param   math.Real lhs
     * @param   math.Real rhs
     * @return  math.Real
     */
    protected function perform(Real $lhs, Real $rhs) {
      if ($lhs instanceof Rational && $rhs instanceof Rational) {
        $sl= $lhs->shortened();
        $sr= $rhs->shortened();
        if ($sl instanceof Integer && $sr instanceof Integer) {
          return new Rational($sl->value % $sr->value);
        }
      }
      throw new IllegalArgumentException('Modulo not defined for '.xp::stringOf($lhs).' % '.xp::stringOf($rhs));
    }
  }
?>
