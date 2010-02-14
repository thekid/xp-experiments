<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest');

  /**
   * Tests class declarations
   *
   */
  class tests·execution·source·ClassDeclarationTest extends ExecutionTest {
    
    /**
     * Test declaring a class
     *
     */
    #[@test]
    public function echoClass() {
      $class= $this->define('class', 'EchoClass', NULL, '{
        public static string[] echoArgs(string[] $args) {
          return $args;
        }
      }');
      $this->assertEquals('SourceEchoClass', $class->getName());
      $this->assertFalse($class->isInterface());
      $this->assertFalse($class->isEnum());
      
      with ($method= $class->getMethod('echoArgs')); {
        $this->assertEquals('echoArgs', $method->getName());
        $this->assertEquals(MODIFIER_STATIC | MODIFIER_PUBLIC, $method->getModifiers());
        $this->assertEquals(Primitive::$ARRAY, $method->getReturnType());
        
        with ($params= $method->getParameters()); {
          $this->assertEquals(1, sizeof($params));
          $this->assertEquals(Primitive::$ARRAY, $params[0]->getType());
        }
        
        $in= array('Hello', 'World');
        $this->assertEquals($in, $method->invoke(NULL, array($in)));
      }
    }

    /**
     * Test declaring a class
     *
     */
    #[@test]
    public function genericClass() {
      $class= $this->define('class', 'ListOf<T>', NULL, '{
        public T[] $elements;
        
        public __construct(T... $initial) {
          $this.elements= $initial;
        }
        
        public self add(T? $element) {
          $this.elements[]= $element;
        }
        
        public static void test(string[] $args) {
          $l= new self<string>();
          foreach ($arg in $args) {
            $l.add($arg);
          }
          return $l;
        }
      }');
      
      $in= array('Hello', 'Hallo', 'Hola');
      $this->assertEquals(
        $in,
        $class->getMethod('test')->invoke(NULL, array($in))->elements
      );
    }

    /**
     * Test declaring an interface
     *
     */
    #[@test]
    public function serializableInterface() {
      $class= $this->define('interface', 'Paintable', NULL, '{
        public void paint(Generic $canvas);
      }');
      $this->assertEquals('SourcePaintable', $class->getName());
      $this->assertTrue($class->isInterface());
      $this->assertFalse($class->isEnum());
      
      with ($method= $class->getMethod('paint')); {
        $this->assertEquals('paint', $method->getName());
        $this->assertEquals(MODIFIER_PUBLIC | MODIFIER_ABSTRACT, $method->getModifiers());
        $this->assertEquals(Type::$VOID, $method->getReturnType());
        
        with ($params= $method->getParameters()); {
          $this->assertEquals(1, sizeof($params));
          $this->assertEquals(XPClass::forName('lang.Generic'), $params[0]->getType());
        }
      }
    }

    /**
     * Test static initializer block
     *
     */
    #[@test]
    public function staticInitializer() {
      $class= $this->define('class', 'StaticInitializer', NULL, '{
        public static self $instance;
        
        static {
          self::$instance= new self();
        }
      }');
      $this->assertClass($class->getField('instance')->get(NULL), $class->getName());
    }

    /**
     * Test static member initialization to complex expressions.
     *
     */
    #[@test]
    public function staticMemberInitialization() {
      $class= $this->define('class', $this->name, NULL, '{
        public static XPClass $arrayClass = lang.types.ArrayList::class;
      }');
      $this->assertClass($class->getField('arrayClass')->get(NULL), 'lang.XPClass');
    }

    /**
     * Test member initialization to complex expressions.
     *
     */
    #[@test]
    public function memberInitialization() {
      $class= $this->define('class', $this->name, NULL, '{
        public lang.types.ArrayList $elements = lang.types.ArrayList::class.newInstance(1, 2, 3);
      }');
      
      with ($instance= $class->newInstance(), $elements= $class->getField('elements')->get($instance)); {
        $this->assertClass($elements, 'lang.types.ArrayList');
        $this->assertEquals(new ArrayList(1, 2, 3), $elements);
      }
    }

    /**
     * Test member initialization to complex expressions.
     *
     */
    #[@test]
    public function memberInitializationWithParent() {
      $class= $this->define('class', $this->name, 'unittest.TestCase', '{
        public lang.types.ArrayList $elements = lang.types.ArrayList::class.newInstance(1, 2, 3);
      }');
      
      with ($instance= $class->newInstance($this->name)); {
        $this->assertEquals($this->name, $instance->getName());
        $elements= $class->getField('elements')->get($instance);
        $this->assertClass($elements, 'lang.types.ArrayList');
        $this->assertEquals(new ArrayList(1, 2, 3), $elements);
      }
    }
  }
?>
