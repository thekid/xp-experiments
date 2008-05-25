<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('math.Expression');

  /**
   * Function call
   *
   * @purpose  Call
   */
  class math·functions·Call extends Object implements math·Expression {
    protected
      $func      = NULL,
      $arguments = array();
    
    /**
     * Constructor
     *
     * @param   math.functions.Function func
     * @param   math.Expression[] arguments
     */
    public function __construct(math·functions·Function $func, $arguments) {
      $this->func= $func;
      $this->arguments= $arguments;
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->func->getClassName().'('.xp::stringOf($this->arguments).')>';
    }
  
    /**
     * Evaluate this expression
     *
     * @return  lang.types.Number
     */
    public function evaluate() {
      $pass= array();
      foreach ($this->arguments as $argument) {
        $pass[]= $argument->evaluate()->asNumber();
      }
      $r= call_user_func_array(array($this->func, 'calculate'), $pass);
      return is_int($r) ? new Rational($r) : new Real($r);
    }
  }
?>
