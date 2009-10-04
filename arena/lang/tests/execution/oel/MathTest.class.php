<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution.oel';

  uses('tests.execution.oel.ExecutionTest');

  /**
   * Tests mathematical operations
   *
   */
  class tests·execution·oel·MathTest extends tests·execution·oel·ExecutionTest {
    
    /**
     * Test addition
     *
     */
    #[@test]
    public function addition() {
      $this->assertEquals(2, $this->run('return 1 + 1;'));
    }

    /**
     * Test subtraction
     *
     */
    #[@test]
    public function subtraction() {
      $this->assertEquals(0, $this->run('return 1 - 1;'));
    }

    /**
     * Test multiplication
     *
     */
    #[@test]
    public function multiplication() {
      $this->assertEquals(2, $this->run('return 2 * 1;'));
    }

    /**
     * Test division
     *
     */
    #[@test]
    public function division() {
      $this->assertEquals(2.0, $this->run('return 4 / 2;'));
    }

  }
?>
