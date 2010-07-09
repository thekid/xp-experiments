<?php
  uses(
    'unittest.TestCase',
    'rdbms.sybasex.TdsNumeric'
  );
  
  class TdsNumericTest extends TestCase {
  
    protected function assertBinaryEquals($expected, $actual, $reason= 'notequal') {
      $expected= unpack('H*', $expected);
      $actual= unpack('H*', $actual);
      $this->assertEquals('0x'.$expected[1], '0x'.$actual[1], $reason);
    }

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
    public function bytesToNegativeValue() {
      $this->assertEquals(
        "-1.00",
        TdsNumeric::fromBytes("\x01\x00\x00\x00\x00\x64", 10, 2)->getValue()
      );
    }

    #[@test]
    public function bytesToNull() {
      $this->assertEquals(
        NULL,
        TdsNumeric::fromBytes("", 10, 6)->getValue()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function aValueToBytes() {
      $this->assertBinaryEquals(
        "\x00\x00\x00\x0f\x42\x40",
        create(new TdsNumeric(1, 10, 6))->getBytes()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function anotherValueToBytes() {
      $this->assertBinaryEquals(
        "\x00\x00\x77\x35\x94\x00",
        create(new TdsNumeric(2000, 10, 6))->getBytes()
      );
    }

     #[@test]
    public function negativeValueToBytes() {
      $this->assertBinaryEquals(
        "\x01\x00\x00\x00\x00\x64",
        create(new TdsNumeric(-1, 10, 2))->getBytes()
      );
    }

  }
?>
