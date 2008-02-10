<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('calc.Node');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  abstract class ExprNode extends calc·Node {
    protected
      $operator = NULL,
      $left     = NULL,
      $right    = NULL;

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public abstract function evaluate();
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function leftVal() {
      return ($this->left instanceof ExprNode
        ? $this->left->evaluate()
        : $this->left
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function rightVal() {
      return ($this->right instanceof ExprNode
        ? $this->right->evaluate()
        : $this->right
      );
    }    
  }
?>
