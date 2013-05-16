<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';
  
  uses('math.Expression');

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
      return sprintf(
        "%s(\n  %s,\n  %s\n)", 
        $this->getClassName(),
        str_replace("\n", "\n  ", xp::stringOf($this->lhs)),
        str_replace("\n", "\n  ", xp::stringOf($this->rhs))
      );
    }
    
    /**
     * Perform this operation
     *
     * @param   math.Real lhs
     * @param   math.Real rhs
     * @return  math.Real
     */
    protected abstract function perform(Real $lhs, Real $rhs);

    /**
     * Evaluate this expression
     *
     * @return  math.Real
     */
    public function evaluate() {
      return $this->perform($this->lhs->evaluate(), $this->rhs->evaluate());
    }
  }
?>
