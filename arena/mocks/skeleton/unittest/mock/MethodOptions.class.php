<?php

/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.mock.IMethodOptions');

  /**
   * TODO
   *
   * @purpose 
   */
  class MethodOptions extends Object implements IMethodOptions {
    private
      $expectation= null;
    
    /**
     * TODO
     */
    public function returns($value) {
        
      return $this;
    }
  }
