<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('math.Expression');

  /**
   * Real number
   *
   * @purpose  Real
   */
  class Real extends Object {
    protected
      $value  = '';
    
    const 
      PRECISION= 16;

    public static 
      $FORMAT      = '',
      $ZERO        = NULL,
      $ONE         = NULL;
      
    static function __static() {
      self::$ZERO= new self('0');
      self::$ONE= new self('1');
      self::$FORMAT= '%.'.self::PRECISION.'F';
      ini_set('precision', self::PRECISION);
    }
        
    /**
     * Constructor. Accepts a float.
     *
     * @param   string in
     */
    public function __construct($in= NULL) {
      $this->value= $in;
    }

    /**
     * Returns this real as a float
     *
     * @return  float
     */
    public function asNumber() {
      return (float)$this->value;
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
     * Compares two reals
     *
     * @param   math.Real cmp
     * @return  int equal: 0, cmp smaller $this: < 0, cmp larger $this: > 0
     */
    public function compareTo(Real $cmp) {
      return strcmp(sprintf(self::$FORMAT, $cmp->asNumber()), sprintf(self::$FORMAT, $this->asNumber()));
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'('.rtrim(rtrim(sprintf(self::$FORMAT, $this->value), '0'), '.').')';
    }
  }
?>
