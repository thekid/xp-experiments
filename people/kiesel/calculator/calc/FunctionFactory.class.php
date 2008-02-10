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
  class FunctionFactory extends Object {
    
    
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
    public static function create($fname, $args) {
      $class= create(new self())->getClass()->getPackage()->loadClass(
        sprintf('%sFunction', ucfirst($fname))
      );
      
      if (NULL === $args) return $class->newInstance();
      return call_user_func_array(array($class, 'newInstance'), $args);
    }
  }
?>
