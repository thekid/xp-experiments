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
  class AnnotationTest extends ParserTestCase {
  
    /**
     * Parse method annotations and return annotations
     *
     * @param   string annotations
     * @return  xp.compiler.Node[]
     */
    protected function parseMethodWithAnnotations($annotations) {
      return create(new xp·compiler·syntax·xp·Parser())->parse(new xp·compiler·syntax·xp·Lexer('abstract class Container {
        '.$annotations.'
        public abstract void method();
      }', '<string:'.$this->name.'>'))->declaration->body['methods'][0]->annotations;
    }

    /**
     * Test no annotation
     *
     */
    #[@test]
    public function noAnnotation() {
      $this->assertEquals(NULL, $this->parseMethodWithAnnotations(''));
    }

    /**
     * Test simple annotation (Test)
     *
     */
    #[@test]
    public function simpleAnnotation() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 15),
        'type'          => 'Test'
      ))), $this->parseMethodWithAnnotations('[@Test]'));
    }

    /**
     * Test simple annotation (Test)
     *
     */
    #[@test, @expect('text.parser.generic.ParseException')]
    public function simpleAnnotationWithBrackets() {
      $this->parseMethodWithAnnotations('[@Test()]');
    }

    /**
     * Test annotation with default value (Expect("lang.IllegalArgumentException"))
     *
     */
    #[@test]
    public function annotationWithStringValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 49),
        'type'          => 'Expect',
        'parameters'    => array('default' => new StringNode(array(
          'position'      => array(2, 18),
          'value'         => 'lang.IllegalArgumentException'
        )))
      ))), $this->parseMethodWithAnnotations('[@Expect("lang.IllegalArgumentException")]'));
    }

    /**
     * Test annotation with default value (Limit(5)))
     *
     */
    #[@test]
    public function annotationWithIntegerValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 18),
        'type'          => 'Limit',
        'parameters'    => array('default' => new IntegerNode(array(
          'position'      => array(2, 17),
          'value'         => '5'
        )))
      ))), $this->parseMethodWithAnnotations('[@Limit(5)]'));
    }

    /**
     * Test annotation with default value (Limit(0x5)))
     *
     */
    #[@test]
    public function annotationWithHexValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 20),
        'type'          => 'Limit',
        'parameters'    => array('default' => new HexNode(array(
          'position'      => array(2, 17),
          'value'         => '0x5'
        )))
      ))), $this->parseMethodWithAnnotations('[@Limit(0x5)]'));
    }

    /**
     * Test annotation with default value (Limit(5.0)))
     *
     */
    #[@test]
    public function annotationWithDecimalValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 20),
        'type'          => 'Limit',
        'parameters'    => array('default' => new DecimalNode(array(
          'position'      => array(2, 17),
          'value'         => '5.0'
        )))
      ))), $this->parseMethodWithAnnotations('[@Limit(5.0)]'));
    }

    /**
     * Test annotation with default value (Limit(null)))
     *
     */
    #[@test]
    public function annotationWithNullValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 21),
        'type'          => 'Limit',
        'parameters'    => array('default' => new NullNode(array(
          'position'      => array(2, 21),
        )))
      ))), $this->parseMethodWithAnnotations('[@Limit(null)]'));
    }

    /**
     * Test annotation with default value (Limit(true)))
     *
     */
    #[@test]
    public function annotationWithTrueValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 21),
        'type'          => 'Limit',
        'parameters'    => array('default' => $this->create(new BooleanNode(TRUE), array(2, 21)))
      ))), $this->parseMethodWithAnnotations('[@Limit(true)]'));
    }

    /**
     * Test annotation with default value (Limit(false)))
     *
     */
    #[@test]
    public function annotationWithFalseValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 22),
        'type'          => 'Limit',
        'parameters'    => array('default' => $this->create(new BooleanNode(FALSE), array(2, 22)))
      ))), $this->parseMethodWithAnnotations('[@Limit(false)]'));
    }

    /**
     * Test annotation with default value (Restrict(["Admin", "Root"]))
     *
     */
    #[@test]
    public function annotationWithArrayValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 37),
        'type'          => 'Restrict',
        'parameters'    => array('default' => new ArrayNode(array(
          'position'      => array(2, 20),
          'values'        => array(
            new StringNode(array('position' => array(2, 21), 'value' => 'Admin')),
            new StringNode(array('position' => array(2, 30), 'value' => 'Root')),
          ),
          'type'          => NULL
        )))
      ))), $this->parseMethodWithAnnotations('[@Restrict(["Admin", "Root"])]'));
    }

    /**
     * Test annotation with default value (Restrict(["Role" : "Root"]))
     *
     */
    #[@test]
    public function annotationWithMapValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 37),
        'type'          => 'Restrict',
        'parameters'    => array('default' => new MapNode(array(
          'position'      => array(2, 20),
          'elements'      => array(array(
            new StringNode(array('position' => array(2, 21), 'value' => 'Role')),
            new StringNode(array('position' => array(2, 30), 'value' => 'Root')),
          )),
          'type'          => NULL
        )))
      ))), $this->parseMethodWithAnnotations('[@Restrict(["Role" : "Root"])]'));
    }

    /**
     * Test annotation with key/value pairs (Expect(classes = [...], code = 503))
     *
     */
    #[@test]
    public function annotationWithValues() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(5, 7),
        'type'          => 'Expect',
        'parameters'    => array(
          'classes' => new ArrayNode(array(
            'position'      => array(3, 19),
            'values'        => array(
              new StringNode(array('position' => array(3, 20), 'value' => 'lang.IllegalArgumentException')),
              new StringNode(array('position' => array(3, 53), 'value' => 'lang.IllegalAccessException')),
            ),
            'type'          => NULL
          )),
          'code'    => new IntegerNode(array(
            'position'      => array(4, 19),
            'value'         => '503',
          )),
        )))
      ), $this->parseMethodWithAnnotations('[@Expect(
        classes = ["lang.IllegalArgumentException", "lang.IllegalAccessException"],
        code    = 503
      )]'));
    }

    /**
     * Test multiple annotations (WebMethod, Deprecated)
     *
     */
    #[@test]
    public function multipleAnnotations() {
      $this->assertEquals(array(
        new AnnotationNode(array('position' => array(2, 20), 'type' => 'WebMethod')),
        new AnnotationNode(array('position' => array(2, 33), 'type' => 'Deprecated')),
      ), $this->parseMethodWithAnnotations('[@WebMethod, @Deprecated]'));
    }
  }
?>
