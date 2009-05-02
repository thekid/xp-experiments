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
        'position'      => array(4, 9),
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
        'position'      => array(4, 9),
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
        'position'      => array(4, 9),
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
        'position'      => array(4, 11),
        'expression'    => new IntegerNode(array(
          'position'      => array(4, 10),
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
        'position'      => array(4, 13),
        'expression'    => new DecimalNode(array(
          'position'      => array(4, 10),
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
        'position'      => array(4, 9),
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
        'position'      => array(4, 9),
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
        array($this->create(new BooleanNode(TRUE), array(3, 17))),
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
        array($this->create(new BooleanNode(FALSE), array(3, 18))),
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
        array($this->create(new NullNode(), array(3, 17))),
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
        'position'      => array(4, 9),
        'values'        => array(
          new IntegerNode(array(
            'position'      => array(4, 10),
            'value'         => '1',
          )),
          new IntegerNode(array(
            'position'      => array(4, 13),
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
        'position'      => array(4, 9),
        'elements'      => array(array(
          new StringNode(array(
            'position'      => array(4, 11),
            'value'         => 'one',
          )),
          new IntegerNode(array(
            'position'      => array(4, 19),
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
        'position'      => array(4, 26),
        'class'         => new TypeName('lang.types.String'),
        'member'        => $this->create(new ConstantNode(array('value' => 'class')), array(4, 28))
      ))), $this->parse("
        lang.types.String::class;
      "));
    }

    /**
     * Test array
     *
     */
    #[@test, @ignore('Not sure whether we want this')]
    public function chainingAfterArrayLiteral() {
      $this->assertEquals(array(new ArrayNode(array(
        'position'      => array(4, 9),
        'values'        => array(
          new IntegerNode(array(
            'position'      => array(4, 10),
            'value'         => '1',
          )),
          new IntegerNode(array(
            'position'      => array(4, 13),
            'value'         => '2',
          )),
        ),
        'type'          => NULL
      ))), $this->parse("
        [1, 2].length;
      "));
    }
  }
?>
