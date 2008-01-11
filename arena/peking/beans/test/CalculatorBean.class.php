<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.TestSuite');

  /**
   * Unittest Runner
   *
   * @purpose  Bean
   */
  #[@bean(type = STATELESS, name = 'xp/test/Calculator')]
  class CalculatorBean extends Object {
 
    /**
     * Adds two numbers and returns the result
     *
     * @param   int a
     * @param   int b
     * @return  int
     */ 
    #[@remote]
    public function add($a, $b) {
      return $a + $b;
    }
  }
?>
