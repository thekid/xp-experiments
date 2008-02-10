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
  class Value extends ExprNode {
    protected
      $value    = NULL;
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($val) {
      if (!is_numeric($val))
        throw new IllegalArgumentException('Not a number: "'.$val.'"');
        
      $this->value= (FALSE === strpos($val, '.')
        ? (int)$val
        : (double)$val
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function evaluate() {
      return $this->value;
    }    
  }
?>
