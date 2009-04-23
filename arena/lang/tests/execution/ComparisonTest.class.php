<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution';

  uses('tests.execution.ExecutionTest');

  /**
   * Tests comparisons
   *
   */
  class tests·execution·ComparisonTest extends ExecutionTest {
    
    /**
     * Test constant == a
     *
     */
    #[@test]
    public function constantLeft() {
      foreach (array('0', 'null', '"string"', '[]', '-1') as $constant) {
        $this->assertEquals(
          TRUE, 
          $this->run('$a= '.$constant.'; return '.$constant.' == $a;'), 
          $constant
        );
      }
    }

    /**
     * Test $a == constant
     *
     */
    #[@test]
    public function constantRight() {
      foreach (array('0', 'null', '"string"', '[]', '-1') as $constant) {
        $this->assertEquals(
          TRUE, 
          $this->run('$a= '.$constant.'; return $a == '.$constant.';'), 
          $constant
        );
      }
    }
  }
?>
