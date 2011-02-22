<?php

/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.reflect.InvocationHandler',
       'lang.reflect.Proxy');

  /**
   * TBD
   *
   * @purpose 
   */
  class MockProxy extends Proxy implements InvocationHandler {
    private
      $returnExpectationMap=array();

    public function __construct() {
      parent::__construct($this);
    }
    /**
     * Processes a method invocation on a proxy instance and returns
     * the result.
     *
     * @param   lang.reflect.Proxy proxy
     * @param   string method the method name
     * @param   var* args an array of arguments
     * @return  var
     */
    public function invoke($proxy, $method, $args) {
      if(!array_key_exists($method, $this->returnExpectationMap))
        return null;

      //return mapped return value
      return $this->returnExpectationMap[$method];
    }

    public function setReturnValue($method, $value) {
      $this->returnExpectationMap[$method]=$value;
    }
  }
