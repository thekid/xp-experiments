<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution.oel';

  uses('tests.execution.oel.ExecutionTest');

  /**
   * Tests arrays
   *
   */
  class tests·execution·oel·ArrayTest extends tests·execution·oel·ExecutionTest {
    
    /**
     * Test [1, 2]
     *
     */
    #[@test]
    public function untypedArray() {
      $this->assertEquals(array(1, 2), $this->run('return [1, 2];'));
    }

    /**
     * Test new string[] { "Hello", "World" }
     *
     */
    #[@test]
    public function typedArray() {
      $this->assertEquals(array('Hello', 'World'), $this->run('return new string[] { "Hello", "World" };'));
    }

    /**
     * Test [1, 2].length
     *
     */
    #[@test, @ignore('Causes "Invalid opcode 82/2/1" - primitive extensions needed')]
    public function arrayLength() {
      $this->assertEquals(2, $this->run('return [1, 2].length;'));
    }
  }
?>
