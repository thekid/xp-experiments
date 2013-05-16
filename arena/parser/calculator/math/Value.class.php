<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'math';
  
  uses('math.Expression', 'lang.types.Number');

  /**
   * Value
   *
   * @purpose  Expression
   */
  class math·Value extends Object implements math·Expression {
    protected
      $number= NULL;
      
    /**
     * Constructor
     *
     * @param   math.Real number
     */
    public function __construct(Real $number) {
      $this->number= $number;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.xp::stringOf($this->number).')';
    }

    /**
     * Evaluate this expression
     *
     * @return  lang.types.Number
     */
    public function evaluate() {
      return $this->number;
    }
  }
?>
