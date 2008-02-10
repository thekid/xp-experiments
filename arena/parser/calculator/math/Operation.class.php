<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';
  
  uses('math.Expression', 'lang.Primitive');

  /**
   * Operation
   *
   * @purpose  Base class
   */
  abstract class math·Operation extends Object implements math·Expression {
    protected
      $lhs= NULL,
      $rhs= NULL;
      
    /**
     * Constructor
     *
     * @param   math.Expression lhs
     * @param   math.Expression rhs
     */
    public function __construct(math·Expression $lhs, math·Expression $rhs) {
      $this->lhs= $lhs;
      $this->rhs= $rhs;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.xp::stringOf($this->lhs).', '.xp::stringOf($this->rhs).')';
    }
    
    /**
     * Perform this operation
     *
     * @param   mixed lhs either a float or int
     * @param   mixed rhs either a float or int
     * @return  mixed either a float or int
     */
    protected abstract function perform($lhs, $rhs);

    /**
     * Evaluate this expression
     *
     * @return  lang.types.Number
     */
    public function evaluate() {
      return Primitive::boxed($this->perform(
        Primitive::unboxed($this->lhs->evaluate()),
        Primitive::unboxed($this->rhs->evaluate())
      ));
    }
  }
?>
