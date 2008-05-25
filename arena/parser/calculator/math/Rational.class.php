<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('math.Real', 'lang.Primitive', 'lang.types.Integer', 'lang.types.Double');

  /**
   * Rational number
   *
   * @purpose  Rational
   */
  class Rational extends Real {
    public
      $numerator   = NULL,
      $denominator = NULL;
    
    /**
     * Constructor. Accepts either x.x (floating point notation) or x/x (fractional notation)
     *
     * @param   string in
     */
    public function __construct($in= NULL) {
      if (strstr($in, '.')) {      // Floating point
        sscanf($in, '%d.%[0-9]', $int, $frac);
        $this->denominator= pow(10, strlen($frac));
        $this->numerator= $this->denominator * $int + $frac;
      } else if (NULL !== $in) {             // Fraction
        sscanf($in, '%d/%[0-9]', $this->numerator, $d);
        $this->denominator= NULL === $d ? 1 : (int)$d;
        if (0 == $this->denominator) {
          throw new IllegalArgumentException('Denominator in '.$in.' may not be zero');
        }
      }
    }

    /**
     * Calculates the greatest common divisor
     *
     * @param   int a
     * @param   int b
     * @return  int
     */
    public static function gcd($a, $b) {
  	  if ($a == $b) return $a; else return $a > $b ? self::gcd($a - $b, $b) : self::gcd($a, $b - $a); 
    }

    /**
     * Calculates the lowest common multiple
     *
     * @param   int a
     * @param   int b
     * @return  int
     */
    public static function lcm($a, $b) {
  	  return $a * $b / self::gcd($a, $b); 
    }
    
    /**
     * Shortens a Rational and returns a number
     *
     * @return  lang.types.Number
     */
    public function shortened() {
      if (0 == $this->numerator) {
        return new Integer(0);    // 0/x
      } else if (1 == $this->denominator) {
        return new Integer($this->numerator); // x/1
      } else {
        $gcd= self::gcd(abs($this->numerator), $this->denominator);
        return ($gcd == $this->denominator) 
          ? new Integer($this->numerator / $gcd)        // 2/2, 10/5
          : new Double($this->numerator / $this->denominator)
        ;
      }
    }
    
    /**
     * Returns this Rational as a number
     *
     * @return  number
     */
    public function asNumber() {
      return Primitive::unboxed($this->shortened());
    }
    
    /**
     * Returns whether an object is equal to this
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && 0 == $this->compareTo($cmp);
    }

    /**
     * Returns two Rationals
     *
     * @param   math.Rational cmp
     * @return  int equal: 0, date before $this: < 0, date after $this: > 0
     */
    public function compareTo(Rational $cmp) {
      $n= $this->numerator * $cmp->denominator - $cmp->numerator * $this->denominator;
      if ($n < 0) return -1;    // a is smaller than b
      if ($n > 0) return 1;     // a is greater than b
      return 0;                         // a equals b
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      if (0 == $this->numerator) {
        return $this->getClassName().'(0)';
      } else if (1 == $this->denominator) {
        return $this->getClassName().'('.$this->numerator.')';
      } else {
        $gcd= self::gcd(abs($this->numerator), $this->denominator);
        return $this->getClassName().'('.(($gcd == $this->denominator) 
          ? $this->numerator / $gcd
          : sprintf('%.0f/%.0f', $this->numerator / $gcd, $this->denominator / $gcd)
        ).')';
      }
    }
  }
?>
