<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.mock.IExpectation');

  /**
 * TODO: Description
 *
 * @see TODO: xp://fqdn
 * @purpose TODO: purpose
 */
  class Expectation extends Object implements IExpectation {

    /**
     * Constructor
     */
    public function __construct() {

    }

    private $return= null;
    public function  getReturn() {
        return $this->return;
    }
    public function setReturn($value) {
        $this->return=$value;
    }

}

