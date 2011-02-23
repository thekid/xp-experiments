<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('unittest.mock.MethodOptions');

  /**
   * TODO
   */
  class MethodOptionsTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new MethodOptions();
    }
      
    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new MethodOptions();
    }

    /**
     * Can call returns.
     */
    #[@test]
    public function canCallReturns() {
      $this->sut->returns(null);
    }

  }
?>
