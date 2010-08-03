<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @see      php://pack
   * @see      php://unpack
   * @see      http://pear.php.net/package/Math_BigInteger/docs/latest/__filesource/fsource_Math_BigInteger__Math_BigInteger-1.0.0RC3BigInteger.php.html#a1669
   * @see      http://sine.codeplex.com/SourceControl/changeset/view/57274#1535069 
   * @ext      bcmath
   */
  abstract class BigNum extends Object {
  
    static function __static() {
      bcscale(ini_get('precision'));
    }
    
    /**
     * Creates a new bignum instance
     *
     * @param   string in
     */
    public function __construct($in) {
      $this->num= (string)$in;
    }
    
    /**
     * +
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function add(self $other) {
      return new $this(bcadd($this->num, $other->num));
    }

    /**
     * -
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function subtract(self $other) {
      return new $this(bcsub($this->num, $other->num));
    }

    /**
     * *
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function multiply(self $other) {
      return new $this(bcmul($this->num, $other->num));
    }

    /**
     * /
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function divide(self $other) {
      if (NULL === ($r= bcdiv($this->num, $other->num))) {
        $e= key(xp::$registry['errors'][__FILE__][__LINE__- 1]);
        xp::gc(__FILE__);
        throw new IllegalArgumentException($e);
      }
      return new $this($r);
    }

    /**
     * %
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function modulo(self $other) {
      if (NULL === ($r= bcmod($this->num, $other->num))) {
        $e= key(xp::$registry['errors'][__FILE__][__LINE__- 1]);
        xp::gc(__FILE__);
        throw new IllegalArgumentException($e);
      }
      return new $this($r);
    }

    /**
     * ^
     *
     * @see     http://en.wikipedia.org/wiki/Exponentiation
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function power(self $other) {
      return new $this(bcpow($this->num, $other->num));
    }

    /**
     * Returns whether another object is equal to this
     *
     * @param   lang.Generic cmp
     * @return  bool
     */
    public function equals($cmp) {
      return $cmp instanceof self && 0 === bccomp($cmp->num, $this->num);
    }
    
    /**
     * Returns an integer representing this bignum
     *
     * @return  int
     */
    public function intValue() {
      return (int)substr($this->num, 0, strcspn($this->num, '.'));
    }
  }
?>
