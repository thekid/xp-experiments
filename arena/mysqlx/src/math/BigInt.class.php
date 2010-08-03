<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('math.BigNum');

  /**
   * (Insert class' description here)
   *
   * @ext      xp://math.BigNum
   */
  class BigInt extends BigNum {
    
    /**
     * &
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function bitwiseAnd(self $other) {
      $a= $this->toBytes();
      $b= $other->toBytes();
      $l= max(strlen($a), strlen($b));
      return self::fromBytes(str_pad($a, $l, "\0", STR_PAD_LEFT) & str_pad($b, $l, "\0", STR_PAD_LEFT));
    }

    /**
     * |
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function bitwiseOr(self $other) {
      $a= $this->toBytes();
      $b= $other->toBytes();
      $l= max(strlen($a), strlen($b));
      return self::fromBytes(str_pad($a, $l, "\0", STR_PAD_LEFT) | str_pad($b, $l, "\0", STR_PAD_LEFT));
    }

    /**
     * ^
     *
     * @param   math.BigNum other
     * @return  math.BigNum
     */
    public function bitwiseXor(self $other) {
      $a= $this->toBytes();
      $b= $other->toBytes();
      $l= max(strlen($a), strlen($b));
      return self::fromBytes(str_pad($a, $l, "\0", STR_PAD_LEFT) ^ str_pad($b, $l, "\0", STR_PAD_LEFT));
    }
    
    /**
     * Creates a bignum from a sequence of bytes
     *
     * @see     xp://math.BigNum#toBytes
     * @param   string bytes
     * @return  math.BigNum
     */
    protected static function fromBytes($bytes) {
      $len= strlen($bytes);
      $len+= (3 * $len) % 4;
      $bytes= str_pad($bytes, $len, "\0", STR_PAD_LEFT);
      $self= new self(0);
      for ($i= 0; $i < $len; $i+= 4) {
        $self->num= bcadd(bcmul($self->num, '4294967296'), 0x1000000 * ord($bytes{$i}) + current(unpack('N', "\0".substr($bytes, $i+ 1, 3))));
      }      
      return $self;
    }
    
    /**
     * Creates sequence of bytes from a bignum
     *
     * @see     xp://math.BigNum#fromBytes
     * @return  string
     */
    protected function toBytes() {
      $n= $this->num;
      $value= '';
      while (bccomp($n, 0) > 0) {
        $value= substr(pack('N', bcmod($n, 0x1000000)), 1).$value;
        $n= bcdiv($n, 0x1000000);
      }
      return ltrim($value, "\0");    
    }
    
    /**
     * String cast overloading
     *
     * @return  string
     */
    public function __toString() {
      return substr($this->num, 0, strcspn($this->num, '.'));
    }
  }
?>
