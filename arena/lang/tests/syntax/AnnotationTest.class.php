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
  class AnnotationTest extends TestCase {
  
    /**
     * Parse method annotations and return annotations
     *
     * @param   string annotations
     * @return  xp.compiler.Node[]
     */
    protected function parseMethodWithAnnotations($annotations) {
      return create(new Parser())->parse(new xp·compiler·Lexer('abstract class Container {
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
        'position'      => array(2, 17),
        'type'          => 'Test'
      ))), $this->parseMethodWithAnnotations('[@Test]'));
    }

    /**
     * Test simple annotation (Test)
     *
     */
    #[@test]
    public function simpleAnnotationWithBrackets() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 18),
        'type'          => 'Test'
      ))), $this->parseMethodWithAnnotations('[@Test()]'));
    }

    /**
     * Test annotation with default value (Expect("lang.IllegalArgumentException"))
     *
     */
    #[@test]
    public function annotationWithDefaultValue() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(2, 49),
        'type'          => 'Expect',
        'parameters'    => array('default' => new StringNode(array(
          'position'      => array(2, 20),
          'value'         => 'lang.IllegalArgumentException'
        )))
      ))), $this->parseMethodWithAnnotations('[@Expect("lang.IllegalArgumentException")]'));
    }

    /**
     * Test annotation with key/value pairs (Expect(classes => [...], code => 503))
     *
     */
    #[@test]
    public function annotationWithValues() {
      $this->assertEquals(array(new AnnotationNode(array(
        'position'      => array(5, 11),
        'type'          => 'Expect',
        'parameters'    => array(
          'classes' => new ArrayNode(array(
            'position'      => array(3, 22),
            'values'        => array(
              new StringNode(array('position' => array(3, 23), 'value' => 'lang.IllegalArgumentException')),
              new StringNode(array('position' => array(3, 54), 'value' => 'lang.IllegalAccessException')),
            ),
            'type'          => NULL
          )),
          'code'    => new NumberNode(array(
            'position'      => array(4, 22),
            'value'         => '503',
          )),
        )))
      ), $this->parseMethodWithAnnotations('[@Expect(
        classes => ["lang.IllegalArgumentException", "lang.IllegalAccessException"],
        code    => 503
      )]'));
    }

    /**
     * Test multiple annotations (WebMethod, Deprecated)
     *
     */
    #[@test]
    public function multipleAnnotations() {
      $this->assertEquals(array(
        new AnnotationNode(array('position' => array(2, 22), 'type' => 'WebMethod')),
        new AnnotationNode(array('position' => array(2, 35), 'type' => 'Deprecated')),
      ), $this->parseMethodWithAnnotations('[@WebMethod, @Deprecated]'));
    }
  }
?>
