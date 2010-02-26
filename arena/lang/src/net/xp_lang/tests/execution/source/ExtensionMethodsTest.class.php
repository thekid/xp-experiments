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
     * Test extending
     *
     */
    #[@test]
    public function sorted() {
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
  }
?>
