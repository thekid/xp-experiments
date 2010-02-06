<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest');

  /**
   * Tests chaining
   *
   */
  class tests·execution·source·ChainingTest extends ExecutionTest {
  
    /**
     * Test
     *
     */
    #[@test]
    public function parentOfTestClass() {
      $this->assertEquals(
        'lang.Object', 
        $this->run('return $this.getClass().getParentClass().getName();')
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function firstMethodOfTestClass() {
      $this->assertEquals(
        'run', 
        $this->run('return $this.getClass().getMethods()[0].getName();')
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function afterNew() {
      $this->assertEquals(
        FALSE, 
        $this->run('return new Object().equals($this);')
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function arrayLength() {
      $this->assertEquals(
        1, 
        $this->run('return new string[]{"Hello"}.length;')
      );
    }
  }
?>
