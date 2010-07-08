<?php

  class TdsNumeric extends Object {
    protected static $bytesPerPrecision= array(
      1, // Actually 0 isn't a precision
      2, 2, 3, 3, 4, 4, 4, 5, 5,
      6, 6, 6, 7, 7, 8, 8, 9, 9, 9,
      10, 10, 11, 11, 11, 12, 12, 13, 13, 14,
      14, 14, 15, 15, 16, 16, 16, 17, 17, 18,
      18, 19, 19, 19, 20, 20, 21, 21, 21, 22,
      22, 23, 23, 24, 24, 24, 25, 25, 26, 26,
      26, 27, 27, 28, 28, 28, 29, 29, 30, 30,
      31, 31, 31, 32, 32, 33, 33, 33
    );
    
    protected
      $value      = NULL,
      $precision  = NULL,
      $scale      = NULL;
    
    public function __construct($value, $precision, $scale) {
      $this->value= $value;
      $this->setPrecision($precision);
      $this->setScale($scale);
    }
    
    public static function fromBytes($bytes, $precision, $scale) {
      $numeric= new self(NULL, $precision, $scale);
      $numeric->bytesToValue($bytes);
      return $numeric;
    }
    
    protected function setPrecision($p) {
      if ($p < 01) throw new SybasexRuntimeException('Precision cannot be smaller than 1.');
      if ($p > 80) throw new SybasexRuntimeException('Precision cannot be greater than 80.');
      
      $this->precision= $p;
    }
    
    protected function setScale($s) {
      if ($s > $this->precision) throw new SybasexRuntimeException('Scale must not be greater than precision.');
      
      $this->scale= $s;
    }
    
    protected function bytesToValue($bytes) {
      if (0 == strlen($bytes)) {
        $this->value= NULL;
        return;
      }
      
      $sign= $bytes[0];
      $bytes= substr($bytes, 0);
      var_dump(bindec($bytes));
      
      $this->value= 0;
      for ($i= 0; $i < strlen($bytes); $i++) {
        $this->value+= ord($bytes{$i}) * pow(2, strlen($bytes)- $i);
      }
    }
    
    protected function valueToBytes($value) {
      raise('lang.MethodNotImplementedException', 'Not implemented', __METHOD__);
    }
    
    public function getValue() {
      return $this->value;
    }
  }
?>