<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'unittest.TestCase',
    'xp.compiler.Lexer',
    'xp.compiler.Parser'
  );

  /**
   * TestCase
   *
   */
  class NumbersTest extends TestCase {
  
    /**
     * Parse method source and return statements inside this method.
     *
     * @param   string src
     * @return  xp.compiler.Node[]
     */
    protected function parse($src) {
      return create(new Parser())->parse(new xp·compiler·Lexer('class Container {
        public void method() {
          '.$src.'
        }
      }', '<string:'.$this->name.'>'))->declaration->body['methods'][0]->body;
    }

    /**
     * Test integer
     *
     */
    #[@test]
    public function integerNumber() {
      $this->assertEquals(array(new NumberNode(array(
        'position'      => array(4, 11),
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
        'position'      => array(4, 13),
        'expression'    => new NumberNode(array(
          'position'      => array(4, 12),
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
        'position'      => array(4, 11),
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
        'position'      => array(4, 11),
        'value'         => '0xFF',
      ))), $this->parse('
        0xFF;
      '));
    }

    /**
     * Test "1.a" raises a parser exception
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function illegalDecimalCharAfterDot() {
      $this->parse('1.a');
    }

    /**
     * Test "1.-" raises a parser exception
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function illegalDecimalMinusAfterDot() {
      $this->parse('0.-');
    }

    /**
     * Test "0xZ" raises a parser exception
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function illegalHexZ() {
      $this->parse('0xZ');
    }

    /**
     * Test "0x" raises a parser exception
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function illegalHexMissingAfterX() {
      $this->parse('0x');
    }
  }
?>
