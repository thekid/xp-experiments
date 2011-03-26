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
     * @return  IMethodOptions
     */
    function returns($value);

    /**
     * Specifies the number of returns for that method. -1 for unlimited.
     *
     * @param int
     */
    function repeat($count);

    /**
     * Specifies that that method may be called an unlimited number of times.
     */
    function repeatAny();
  }
?>