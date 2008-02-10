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
  class FunctionNode extends Object {
    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    private function __construct() {
    }
        
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public static function create($fname) {
      return create(new self())->getClass()->getPackage()->loadClass(
        sprintf('%sFunction', ucfirst($fname))
      )->newInstance();
    }
  }
?>
