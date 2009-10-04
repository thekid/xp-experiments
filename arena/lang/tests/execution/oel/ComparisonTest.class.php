<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution.oel';

  uses('tests.execution.oel.ExecutionTest');

  /**
   * Tests comparisons
   *
   */
  class tests·execution·oel·ComparisonTest extends tests·execution·oel·ExecutionTest {
    
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
