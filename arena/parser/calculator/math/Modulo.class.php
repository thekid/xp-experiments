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
     * @param   mixed lhs int
     * @param   mixed rhs int
     * @return  mixed int
     */
    protected function perform($lhs, $rhs) {
      return $lhs % $rhs;
    }
  }
?>
