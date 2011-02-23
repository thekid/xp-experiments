<?php
/* This class is part of the XP framework
 *
 * $Id$
 */


  uses('unittest.mock.Expectation');

  /**
 * Test cases for
 */
  class ExpectationTest extends TestCase {

    private $sut = null;

    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
        $this->sut = new Expectation();
    }


    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
        new Expectation();
    }



  }
