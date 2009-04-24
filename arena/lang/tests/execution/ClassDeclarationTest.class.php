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
  class tests�execution�ClassDeclarationTest extends ExecutionTest {
    
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
     * Test declaring an interface
     *
     */
    #[@test]
    public function comparableInterface() {
      $class= $this->define('interface', 'Comparable', '{
        public int compareTo(Generic $in);
      }');
      $this->assertEquals('Comparable', $class->getName());
      
      with ($method= $class->getMethod('compareTo')); {
        $this->assertEquals('compareTo', $method->getName());
        $this->assertEquals(MODIFIER_PUBLIC | MODIFIER_ABSTRACT, $method->getModifiers());
        $this->assertEquals(Primitive::$INTEGER, $method->getReturnType());
        
        with ($params= $method->getParameters()); {
          $this->assertEquals(1, sizeof($params));
          $this->assertEquals(XPClass::forName('lang.Generic'), $params[0]->getType());
        }
      }
    }

    /**
     * Test
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
      $this->assertEquals('StaticInitializer', $class->getField('instance')->get(NULL)->getClassName());
    }
  }
?>