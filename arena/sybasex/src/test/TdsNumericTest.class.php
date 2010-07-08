<?php
  uses(
    'unittest.TestCase',
    'rdbms.sybasex.TdsNumeric'
  );
  
  class TdsNumericTest extends TestCase {
  
    #[@test]
    public function bytesToAValue() {
      $this->assertEquals(
        1,
        TdsNumeric::fromBytes("\000\000\000\015\066\064", 10, 6)->getValue()
      );
    }
    
    #[@test]
    public function bytesToAnotherValue() {
      $this->assertEquals(
        2000,
        TdsNumeric::fromBytes("\000\000\119\053\148\000", 10, 6)->getValue()
      );
    }
    
    #[@test]
    public function bytesToNull() {
      $this->assertEquals(
        NULL,
        TdsNumeric::fromBytes("", 10, 6)->getValue()
      );
    }
  }
?>