<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('calc.ExprNode');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AbsFunction extends ExprNode {
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($val) {
      $this->left= $val;
    }
        
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function evaluate() {
      return abs($this->leftVal());
    }
  }
?>
