<?php

  /* This interface is part of the XP framework
   *
   * $Id$
   */

  /**
   * Fluent interface for specifying mock expectation.
   *
   * @purpose  Mockery
   */
  interface IMethodOptions {
    
    /**
     * Specifies return value for that method call.
     *
     * @param   mixed The return value for that expectation.
     * @return  var
     */
    function returns($value);

    function repeat($count);

    function repeatAny();
  }
?>