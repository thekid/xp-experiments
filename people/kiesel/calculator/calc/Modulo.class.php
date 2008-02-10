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
  class Modulo extends ExprNode {
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($left, $right) {
      $this->left= $left;
      $this->right= $right;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function evaluate() {
      return $this->leftVal() % $this->rightVal();
    }    
  }
?>
