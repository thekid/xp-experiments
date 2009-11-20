<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.log.LogCategory');

  /**
   * A single log event
   *
   * @test    xp://test.LoggingEventTest
   */
  class LoggingEvent extends Object {
    protected $category= NULL;
    protected $timestamp= 0;
    protected $processId= 0;
    protected $level= 0;
    protected $message= '';
    
    /**
     * Creates a new logging event
     *
     * @param   util.log.LogCategory category
     * @param   int timestamp
     * @param   int processId
     * @param   int level one debug, info, warn or error
     * @param   string message
     */
    public function __construct($category, $timestamp, $processId, $level, $message) {
      $this->category= $category;
      $this->timestamp= $timestamp;
      $this->processId= $processId;
      $this->level= $level;
      $this->message= $message;
    }
        
    /**
     * Gets category
     *
     * @return  util.log.LogCategory
     */
    public function getCategory() {
      return $this->category;
    }

    /**
     * Gets timestamp
     *
     * @return  int
     */
    public function getTimestamp() {
      return $this->timestamp;
    }

    /**
     * Gets processId
     *
     * @return  int
     */
    public function getProcessId() {
      return $this->processId;
    }

    /**
     * Gets level
     *
     * @see     xp://util.log.LogLevel
     * @return  int
     */
    public function getLevel() {
      return $this->level;
    }

    /**
     * Gets message
     *
     * @return  string
     */
    public function getMessage() {
      return $this->message;
    }
  }
?>
