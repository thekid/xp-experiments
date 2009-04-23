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
     * Test declaring a class with a main method
     *
     */
    #[@test]
    public function withMainMethod() {
      $class= $this->define('TestClass·1', '{
        public static void main(string[] $args) {
        
        }
      }');
      $this->assertEquals('TestClass·1', $class->getName());
      
      with ($method= $class->getMethod('main')); {
        $this->assertEquals('main', $method->getName());
        $this->assertEquals(MODIFIER_STATIC | MODIFIER_PUBLIC, $method->getModifiers());
        $this->assertEquals(Type::$VOID, $method->getReturnType());
        
        with ($params= $method->getParameters()); {
          $this->assertEquals(1, sizeof($params));
          $this->assertEquals(Primitive::$ARRAY, $params[0]->getType());
        }
        
        $method->invoke(NULL, array(array('Hello', 'World')));
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function staticInitializer() {
      $class= $this->define('StaticInitializer', '{
        public static self $instance;
        
        static {
          self::$instance= new self();
        }
      }');
      $this->assertEquals('StaticInitializer', $class->getField('instance')->get(NULL)->getClassName());
    }
  }
?>
