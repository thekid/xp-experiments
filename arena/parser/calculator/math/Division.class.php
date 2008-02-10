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
     * @param   mixed lhs either a float or int
     * @param   mixed rhs either a float or int
     * @return  mixed either a float or int
     */
    protected function perform($lhs, $rhs) {
      return $lhs / $rhs;
    }
  }
?>
