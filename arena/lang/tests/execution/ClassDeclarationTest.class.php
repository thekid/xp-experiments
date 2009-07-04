<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution';

  uses('tests.execution.ExecutionTest');

  /**
   * Tests class declarations
   *
   */
  class tests·execution·ClassDeclarationTest extends ExecutionTest {
    
    /**
     * Test declaring a class
     *
     */
    #[@test]
    public function echoClass() {
      $class= $this->define('class', 'EchoClass', '{
        public static string[] echoArgs(string[] $args) {
          return $args;
        }
      }');
      $this->assertEquals('EchoClass', $class->getName());
      
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
     * Test static initializer block
     *
     */
    #[@test]
    public function staticInitializer() {
      $class= $this->define('class', 'StaticInitializer', '{
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
      $class= $this->define('class', $this->name, '{
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
      $class= $this->define('class', $this->name, '{
        public lang.types.ArrayList $elements = lang.types.ArrayList::class.newInstance(1, 2, 3);
      }');
      
      // FIXME: The constructor calls "parent::__construct()" via call_user_func_array()
      // internally which works perfectly but causes a warning to be issued
      with ($instance= @$class->newInstance(), $elements= $class->getField('elements')->get($instance)); {
        $this->assertClass($elements, 'lang.types.ArrayList');
        $this->assertEquals(new ArrayList(1, 2, 3), $elements);
      }
    }
  }
?>
