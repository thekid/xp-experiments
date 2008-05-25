<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';
  
  uses('math.Real', 'math.Rational');

  /**
   * Represents an expression
   *
   * @see      xp://math.Value
   * @see      xp://math.Constant
   * @see      xp://math.Operation
   * @purpose  Base interface
   */
  interface math·Expression {
    
    /**
     * Evaluate this expression
     *
     * @return  math.Real
     */
    public function evaluate();
  }
?>
