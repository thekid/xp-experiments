<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'net.xp_lang.tests.execution.source';

  uses('net.xp_lang.tests.execution.source.ExecutionTest', 'lang.Enum');

  /**
   * Tests class declarations
   *
   */
  class net·xp_lang·tests·execution·source·ExtensionMethodsTest extends ExecutionTest {

    /**
     * Test extending a class
     *
     */
    #[@test]
    public function classExtension() {
      $class= $this->define('class', 'ClassExtension', NULL, '{
        public static lang.reflect.Method[] methodsNamed(this lang.XPClass $class, text.regex.Pattern $pattern) {
          $r= new lang.reflect.Method[] { };
          foreach ($method in $class.getMethods()) {
            if ($pattern.matches($method.getName())) $r[]= $method;
          }
          return $r;
        }
        
        public lang.reflect.Method runMethod() {
          return self::class.methodsNamed(text.regex.Pattern::compile("run"))[0];
        }
      }');
      $this->assertEquals(
        $class->getMethod('runMethod'), 
        $class->newInstance()->runMethod()
      );
    }

    /**
     * Test extending a primitive
     *
     */
    #[@test]
    public function stringExtension() {
      $class= $this->define('class', 'StringExtension', NULL, '{
        public static bool equal(this string $in, string $cmp, bool $strict) {
          return $strict ? $in === $cmp : $in == $cmp;
        }
        
        public bool run(string $cmp) {
          return "hello".equal($cmp, true);
        }
      }');
      $instance= $class->newInstance();
      $this->assertFalse($instance->run('world'));
      $this->assertTrue($instance->run('hello'));
    }
 
     /**
     * Test extending an array
     *
     */
    #[@test]
    public function arrayExtension() {
      $class= $this->define('class', 'MethodExtension', NULL, '{
        protected static string[] names(this lang.reflect.Method[] $methods) {
          $r= [];
          foreach ($method in $methods) {
            $r[]= $method.getName();
          }
          return $r;
        }
        
        public bool run(XPClass $class) {
          return $class.getMethods().names();
        }
      }');
      $instance= $class->newInstance();
      $this->assertEquals(
        array('hashCode', 'equals', 'getClassName', 'getClass', 'toString'),
        $instance->run(XPClass::forName('lang.Object'))
      );
    }
 }
?>
