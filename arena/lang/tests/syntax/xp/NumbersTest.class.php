<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('tests.syntax.xp.ParserTestCase');

  /**
   * TestCase
   *
   */
  class NumbersTest extends ParserTestCase {
  
    /**
     * Test integer
     *
     */
    #[@test]
    public function integerNumber() {
      $this->assertEquals(array(new IntegerNode(array(
        'position'      => array(4, 9),
        'value'         => '1',
      ))), $this->parse('
        1;
      '));
    }

    /**
     * Test negative integer
     *
     */
    #[@test]
    public function negativeIntegerNumber() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'position'      => array(4, 11),
        'expression'    => new IntegerNode(array(
          'position'      => array(4, 10),
          'value'         => '1',
        )),
        'op'            => '-'
      ))), $this->parse('
        -1;
      '));
    }

    /**
     * Test decimal
     *
     */
    #[@test]
    public function decimalNumber() {
      $this->assertEquals(array(new DecimalNode(array(
        'position'      => array(4, 9),
        'value'         => '1.0',
      ))), $this->parse('
        1.0;
      '));
    }

    /**
     * Test hex
     *
     */
    #[@test]
    public function hexNumber() {
      $this->assertEquals(array(new HexNode(array(
        'position'      => array(4, 9),
        'value'         => '0xFF',
      ))), $this->parse('
        0xFF;
      '));
    }

    /**
     * Test "1.a" raises a parser exception
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function illegalDecimalCharAfterDot() {
      $this->parse('1.a');
    }

    /**
     * Test "1.-" raises a parser exception
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function illegalDecimalMinusAfterDot() {
      $this->parse('0.-');
    }

    /**
     * Test "0xZ" raises a parser exception
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function illegalHexZ() {
      $this->parse('0xZ');
    }

    /**
     * Test "0x" raises a parser exception
     *
     */
    #[@test, @expect('lang.FormatException')]
    public function illegalHexMissingAfterX() {
      $this->parse('0x');
    }
  }
?>
