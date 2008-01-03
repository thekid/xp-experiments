<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Fraction extends Object {
    protected
      $numerator    = NULL,
      $denominator  = NULL;
    
    public function __construct($numerator, $denominator) {
      if (!is_int($numerator)) throw new IllegalArgumentException('First argument must be integer.');
      if (!is_int($denominator)) throw new IllegalArgumentException('Second argument must be integer.');
      if (0 == $denominator) throw new IllegalArgumentException('Denominator may not be zero.');
      
      $this->numerator= $numerator;
      $this->denominator= $denominator;
    }
    
    public function getNumerator() {
      return $this->numerator;
    }
    
    public function getDenominator() {
      return $this->denominator;
    }
    
    public function asFloat() {
      return $this->numerator / $this->denominator;
    }
    
    public function isInteger() {
      return (bool)0 == ($this->numerator % $this->denominator);
    }
    
    public function reduce() {
      if (0 == $this->numerator % $this->denominator) {
        $this->numerator/= $this->denominator;
        $this->denominator= 1;
      }
      
      // Find greatest common divisor, using the modern
      // iterative variant of Euclid's algorithm
      $n= $this->numerator; $d= $this->denominator;
      while ($d != 0) {
        $h= $n % $d;
        $n= $d;
        $d= $h;
      }
      $this->numerator/= $n;
      $this->denominator/= $n;
      return $this;
    }
    
    public function equals($cmp) {
      if (!$cmp instanceof self) return FALSE;
      return (
        $cmp->numerator === $this->numerator &&
        $cmp->denominator === $this->denominator
      );
    }
    
    public function toString() {
      return '('.$this->numerator.'/'.$this->denominator.')';
    }
  }
?>
