<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest');

  /**
   * Tests comparisons
   *
   */
  class tests·execution·source·ComparisonTest extends ExecutionTest {
    
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
     * Test constant === a
     *
     */
    #[@test]
    public function constantLeftIdentical() {
      foreach (array('0', 'null', '"string"', '[]', '-1') as $constant) {
        $this->assertEquals(
          TRUE, 
          $this->run('$a= '.$constant.'; return '.$constant.' === $a;'), 
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

    /**
     * Test $a == constant
     *
     */
    #[@test]
    public function constantRightIdentical() {
      foreach (array('0', 'null', '"string"', '[]', '-1') as $constant) {
        $this->assertEquals(
          TRUE, 
          $this->run('$a= '.$constant.'; return $a === '.$constant.';'), 
          $constant
        );
      }
    }
  }
?>
