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
  class SignReversion extends ExprNode {

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
      return -1 * $this->leftVal();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public static function createFor($value) {
      if ($value instanceof Value) return new Value(-1 * $value->evaluate());
      return new self($value);
    }
  }
?>
