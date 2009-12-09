<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest');

  /**
   * Tests lambdas
   *
   */
  class tests·execution·source·LambdaTest extends ExecutionTest {
    
    /**
     * Test 
     *
     */
    #[@test]
    public function apply() {
      $this->assertEquals(array(2, 4, 6), $this->run(
        'return apply([1, 2, 3], { $a => $a * 2 });',
        array('import static tests.execution.source.Functions.apply;')
      ));
    }

    /**
     * Test 
     *
     */
    #[@test]
    public function applyWithCapturing() {
      $this->assertEquals(array(3, 6, 9), $this->run(
        '$mul= 3; return apply([1, 2, 3], { $a => $a * $mul });',
        array('import static tests.execution.source.Functions.apply;')
      ));
    }
  }
?>
