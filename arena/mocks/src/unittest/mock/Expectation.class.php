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

    private $repeat=0;
    public function  getRepeat() {
        return $this->repeat;
    }
    public function setRepeat($value) {
        $this->repeat=$value;
    }

    private $actualCalls=0;
    public function getActualCalls() {
        return $this->actualCalls;
    }
    public function incActualCalls() {
        $this->actualCalls += 1;
    }

    public function canRepeat() {
      return $this->repeat==-1 //unlimited repeats
          || $this->actualCalls <= $this->repeat; //limit not reached
    }
}

?>