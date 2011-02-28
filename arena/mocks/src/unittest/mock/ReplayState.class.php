<?php

/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.mock.IMockState',
       'lang.IllegalArgumentException',
       'util.Hashmap',
       'util.collections.Vector');

  /**
   * Replaying state.
   *
   * @purpose Replay expectations 
   */
  class ReplayState extends Object implements IMockState {
    private
      $expectationMap= null;
        
    /**
     * Constructor
     *
     * @param Hashmap expectationsMap
     */
    public function  __construct($expectationMap) {
      if(!($expectationMap instanceof Hashmap))
        throw new IllegalArgumentException('Invalid expectation map passed.');
      
      $this->expectationMap= $expectationMap;
    }
    /**
     * Handles calls to methods regarding the 
     *
     * @param   string method the method name
     * @param   var* args an array of arguments
     * @return  var
     */
    public function handleInvocation($method, $args) {

    }
  }
