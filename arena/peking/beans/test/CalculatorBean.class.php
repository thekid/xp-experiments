<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.types.Integer');

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

    /**
     * Adds two lang.types.Integers and returns the result
     *
     * @param   lang.types.Integer a
     * @param   lang.types.Integer b
     * @return  lang.types.Integer
     */ 
    #[@remote]
    public function addIntegers(Integer $a, Integer $b) {
      return new Integer($a->value + $b->value);
    }
  }
?>
