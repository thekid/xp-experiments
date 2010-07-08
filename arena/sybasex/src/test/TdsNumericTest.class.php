<?php
  uses(
    'unittest.TestCase',
    'rdbms.sybasex.TdsNumeric'
  );
  
  class TdsNumericTest extends TestCase {
  
    #[@test]
    public function bytesToAValue() {
      $this->assertEquals(
        "1.000000",
        TdsNumeric::fromBytes("\x00\x00\x00\x0f\x42\x40", 10, 6)->getValue()
      );
    }
    
    #[@test]
    public function bytesToAnotherValue() {
      $this->assertEquals(
        "2000.000000",
        TdsNumeric::fromBytes("\x00\x00\x77\x35\x94\x00", 10, 6)->getValue()
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
