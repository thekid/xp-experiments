<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution';

  uses('tests.execution.ExecutionTest');

  /**
   * Tests loop executions
   *
   */
  class tests·execution·LoopExecutionTest extends ExecutionTest {
    
    /**
     * Test foreach
     *
     */
    #[@test]
    public function foreachLoop() {
      $this->assertEquals(array(1, 2, 3), $this->run('
        $r= []; 
        foreach ($arg in [1, 2, 3]) { $r[]= $arg; } 
        return $r;
      '));
    }

    /**
     * Test foreach
     *
     */
    #[@test]
    public function emptyForeachLoop() {
      $this->assertNull($this->run('foreach ($arg in [1, 2, 3]) { }'));
    }
  }
?>
