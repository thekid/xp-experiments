<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'tests.execution.source';

  uses('tests.execution.source.ExecutionTest');

  /**
   * Tests with statement
   *
   */
  class tests·execution·source·WithTest extends ExecutionTest {
    
    /**
     * Test
     *
     */
    #[@test]
    public function oneAssignment() {
      $this->assertEquals('child', $this->run('with ($n= new xml.Node("root").addChild(new xml.Node("child"))) { 
        return $n.getName(); 
      }'));
    }
  }
?>
