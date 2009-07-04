<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution';

  uses('tests.execution.ExecutionTest', 'lang.Enum');

  /**
   * Tests class declarations
   *
   */
  class tests·execution·EnumDeclarationTest extends ExecutionTest {
    

    /**
     * Test declaring an enum
     *
     */
    #[@test]
    public function weekdayEnum() {
      $class= $this->define('enum', 'WeekDay', NULL, '{
        MON, TUE, WED, THU, FRI, SAT, SUN;
        
        public bool isWeekend() {
          return $this.ordinal > self::$FRI.ordinal;
        }
      }');
      $this->assertEquals('WeekDay', $class->getName());
      $this->assertTrue($class->isEnum());
      
      with ($method= $class->getMethod('isWeekend')); {
        $this->assertEquals('isWeekend', $method->getName());
        $this->assertEquals(MODIFIER_PUBLIC, $method->getModifiers());
        $this->assertEquals(Primitive::$BOOLEAN, $method->getReturnType());
        $this->assertEquals(0, $method->numParameters());
      }

      $this->assertEquals('WED', Enum::valueOf($class, 'WED')->name());
      $this->assertEquals('SAT', Enum::valueOf($class, 'SAT')->name());
      $this->assertTrue(Enum::valueOf($class, 'SUN')->isWeekend());
      $this->assertFalse(Enum::valueOf($class, 'MON')->isWeekend());
    }
  }
?>
