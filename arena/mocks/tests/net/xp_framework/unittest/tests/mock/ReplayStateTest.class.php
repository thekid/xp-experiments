<?php
/* This class is part of the XP framework
 *
 * $Id$
 */
 
  uses('unittest.mock.ReplayState');

  /**
   * TODO: Description
   *
   * @see      xp://unittest.mock.Replay
   * @purpose  Unit Test
   */
  class ReplayStateTest extends TestCase {

    private $sut=null;
    /**
     * Creates the fixture;
     *
     */
    public function setUp() {
      $this->sut=new ReplayState();
    }
      
    /**
     * Can create.
     */
    #[@test]
    public function canCreate() {
      new ReplayState();
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
