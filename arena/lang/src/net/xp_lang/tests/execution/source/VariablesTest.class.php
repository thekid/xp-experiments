<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'net.xp_lang.tests.execution.source';

  uses('net.xp_lang.tests.execution.source.ExecutionTest');

  /**
   * Tests variables
   *
   */
  class net·xp_lang·tests·execution·source·VariablesTest extends ExecutionTest {
    
    /**
     * Tests assigning to a regular variable
     *
     */
    #[@test]
    public function toVariable() {
      $this->assertEquals(1, $this->run('$a= 1; return $a;'));
    }

    /**
     * Tests assigning to a member variable
     *
     */
    #[@test]
    public function toMember() {
      $this->assertEquals(1, $this->run('$this.member= 1; return $this.member;'));
    }
    
    /**
     * Tests $a= $b= 1;
     *
     */
    #[@test]
    public function duplicate() {
      $this->assertEquals(array(1, 1), $this->run('$a= $b= 1; return [$a, $b];'));
    }

    /**
     * Tests $a= $b= $c= 1;
     *
     */
    #[@test]
    public function triple() {
      $this->assertEquals(array(1, 1, 1), $this->run('$a= $b= $c= 1; return [$a, $b, $c];'));
    }
  }
?>
