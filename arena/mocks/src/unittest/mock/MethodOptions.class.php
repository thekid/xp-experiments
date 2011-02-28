<?php

/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.mock.IMethodOptions',
       'unittest.mock.Expectation');

  /**
   * Implements a fluent interface for specifying mock expectation.
   *
   * @purpose Mocking
   */
  class MethodOptions extends Object implements IMethodOptions {
    private
      $expectation= null;

    /**
     * Constructor
     *
     * @param Array expectation
     */
    public function  __construct($expectation) {
      if(!($expectation instanceof Expectation))
        throw new IllegalArgumentException('Invalid expectation map passed.');

      $this->expectation= $expectation;
    }
    
    /**
     * Specifies the expected return value.
     */
    public function returns($value) {
      $this->expectation->setReturn($value);
      return $this;
    }
  }
?>