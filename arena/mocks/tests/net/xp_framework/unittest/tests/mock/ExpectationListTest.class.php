<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('unittest.mock.ExpectationList');
  
/**
 * Test cases for the ExpectationList class
 *
 * @purpose Unit tests
 */
  class ExpectationListTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new ExpectationList();
    }
      
    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new ExpectationList();
    }

  }
?>