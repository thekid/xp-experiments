<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';

  /**
   * Represents an expression
   *
   * @see      xp://math.Constant
   * @see      xp://math.Operation
   * @purpose  Base interface
   */
  interface math·Expression {
    
    /**
     * Evaluate this expression
     *
     * @return  lang.types.Number
     */
    public function evaluate();
  }
?>
