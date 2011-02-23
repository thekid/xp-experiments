<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('unittest.mock.RecordState');

  /**
   * TODO: Description
   *
   * @see      xp://unittest.mock.RecordState
   * @purpose  Unit Test
   */
  class RecordStateTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new RecordState();
    }
      
    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new RecordState();
    }
    
    /**
     * Can create.
     */
    #[@test]
    public function canHandleInvocation() {
      $this->sut->handleInvocation(null, null);
    }
  }
?>
