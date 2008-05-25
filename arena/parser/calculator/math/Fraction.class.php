<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math';

  uses('math.Expression');

  /**
   * Division
   *
   * @purpose  Operation implementation
   */
  class math·Fraction extends Object implements math·Expression {
    protected
      $numerator   = NULL,
      $denominator = NULL;
      
    /**
     * Constructor
     *
     * @param   math.Expression numerator
     * @param   math.Expression denominator
     */
    public function __construct(math·Expression $numerator, math·Expression $denominator) {
      $this->numerator= $numerator;
      $this->denominator= $denominator;
    }

    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.xp::stringOf($this->numerator).'/'.xp::stringOf($this->denominator).')';
    }

    /**
     * Evaluate this expression
     *
     * @return  math.Real
     */
    public function evaluate() {
      $n= $this->numerator->evaluate();
      $d= $this->denominator->evaluate();
      
      if (Real::$ZERO->equals($d)) throw new IllegalArgumentException('Denominator may not be zero');
      if (Real::$ZERO->equals($n)) return new Rational('0');
      if ($n->equals($d)) return new Rational('1');
      
      if ($n instanceof Rational && $d instanceof Rational) {
        $r= new Rational();
        $r->numerator= $n->numerator * $d->denominator;
        $r->denominator= $n->denominator * $d->numerator;
        return $r;
      }
      
      return new Real($n->asNumber() / $d->asNumber());
    }
  }
?>
