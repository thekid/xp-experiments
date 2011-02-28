<?php

/* This interface is part of the XP framework
 *
 * $Id$
 */

/**
 * Interface for expectation types
 *
 * @see      xp://unittest.mock.IExpectation
 * @purpose  Mocking
 */
  interface IExpectation {
    function getReturn();
    function setReturn($value);
  }
?>