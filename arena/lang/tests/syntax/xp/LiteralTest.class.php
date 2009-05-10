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
  class LiteralTest extends ParserTestCase {
  
    /**
     * Test double-quoted string
     *
     */
    #[@test]
    public function doubleQuotedStringLiteral() {
      $this->assertEquals(array(new StringNode(array(
        'value'         => 'Hello World',
      ))), $this->parse('
        "Hello World";
      '));
    }

    /**
     * Test single-quoted string
     *
     */
    #[@test]
    public function singleQuotedStringLiteral() {
      $this->assertEquals(array(new StringNode(array(
        'value'         => 'Hello World',
      ))), $this->parse("
        'Hello World';
      "));
    }

    /**
     * Test number
     *
     */
    #[@test]
    public function numberLiteral() {
      $this->assertEquals(array(new IntegerNode(array(
        'value'         => '1',
      ))), $this->parse("
        1;
      "));
    }

    /**
     * Test negative number
     *
     */
    #[@test]
    public function negativeInt() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'expression'    => new IntegerNode(array(
          'value'         => '1',
        )),
        'op'            => '-'
      ))), $this->parse("
        -1;
      "));
    }

    /**
     * Test negative number
     *
     */
    #[@test]
    public function negativeDecimal() {
      $this->assertEquals(array(new UnaryOpNode(array(
        'expression'    => new DecimalNode(array(
          'value'         => '1.0',
        )),
        'op'            => '-'
      ))), $this->parse("
        -1.0;
      "));
    }

    /**
     * Test hex
     *
     */
    #[@test]
    public function hexLiteral() {
      $this->assertEquals(array(new HexNode(array(
        'value'         => '0x0',
      ))), $this->parse("
        0x0;
      "));
    }

    /**
     * Test decimal
     *
     */
    #[@test]
    public function decimalLiteral() {
      $this->assertEquals(array(new DecimalNode(array(
        'value'         => '1.0',
      ))), $this->parse("
        1.0;
      "));
    }

    /**
     * Test true
     *
     */
    #[@test]
    public function booleanTrueLiteral() {
      $this->assertEquals(
        array(new BooleanNode(TRUE)),
        $this->parse('true;')
      );
    }

    /**
     * Test true
     *
     */
    #[@test]
    public function booleanFalseLiteral() {
      $this->assertEquals(
        array(new BooleanNode(FALSE)),
        $this->parse('false;')
      );
    }

    /**
     * Test null
     *
     */
    #[@test]
    public function nullLiteral() {
      $this->assertEquals(
        array(new NullNode()),
        $this->parse('null;')
      );
    }

    /**
     * Test array
     *
     */
    #[@test]
    public function arrayLiteral() {
      $this->assertEquals(array(new ArrayNode(array(
        'values'        => array(
          new IntegerNode(array(
            'value'         => '1',
          )),
          new IntegerNode(array(
            'value'         => '2',
          )),
        ),
        'type'          => NULL
      ))), $this->parse("
        [1, 2];
      "));
    }

    /**
     * Test map
     *
     */
    #[@test]
    public function mapLiteral() {
      $this->assertEquals(array(new MapNode(array(
        'elements'      => array(array(
          new StringNode(array(
            'value'         => 'one',
          )),
          new IntegerNode(array(
            'value'         => '1',
          )),
        )),
        'type'          => NULL
      ))), $this->parse("
        [ 'one' : 1 ];
      "));
    }

    /**
     * Test class
     *
     */
    #[@test]
    public function classLiteral() {
      $this->assertEquals(array(new ClassMemberNode(array(
        'class'         => new TypeName('lang.types.String'),
        'member'        => new ConstantNode(array('value' => 'class'))
      ))), $this->parse("
        lang.types.String::class;
      "));
    }

    /**
     * Test array
     *
     */
    #[@test]
    public function chainingAfterArrayLiteral() {
      $this->assertEquals(array(new ChainNode(array(
        0 => new ArrayNode(array(
          'values'        => array(
            new IntegerNode(array(
              'value'         => '1',
            )),
            new IntegerNode(array(
              'value'         => '2',
            )),
          ),
          'type'          => NULL
        )),
        1 => new VariableNode('array')
      ))), $this->parse("
        [1, 2].array;
      "));
    }
  }
?>
