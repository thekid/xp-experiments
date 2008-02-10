<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('calc.FunctionNode');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class PiFunction extends ExprNode {
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function evaluate() {
      return pi();
    }
  }
?>
