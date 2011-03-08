<?php
  /* This interface is part of the XP framework
   *
   * $Id$
   */

  /**
   * Interface for mock objects
   *
   * @purpose  Mockery
   */
  interface IMock{
    function _replayMock();
    function _isMockRecording();
    function _isMockReplaying();
    function _verifyMock();
  }
?>