<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.mock.IExpectation');

  /**
   * Expectation to a method call.
   *
   * @see xp://unittest.mock.Expectation
   * @purpose Mocking
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

?>