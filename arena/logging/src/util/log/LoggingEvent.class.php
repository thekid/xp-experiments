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
    protected $arguments= array();
    
    /**
     * Creates a new logging event
     *
     * @param   util.log.LogCategory category
     * @param   int timestamp
     * @param   int processId
     * @param   int level one debug, info, warn or error
     * @param   var[] arguments
     */
    public function __construct($category, $timestamp, $processId, $level, array $arguments) {
      $this->category= $category;
      $this->timestamp= $timestamp;
      $this->processId= $processId;
      $this->level= $level;
      $this->message= implode(' ', array_map(array($this, 'stringOf'), $arguments));
    }
    
    /**
     * Creates a string representation of the given argument. For any 
     * string given, the result is the string itself, for any other type,
     * the result is the xp::stringOf() output.
     *
     * @param   var arg
     * @return  string
     */
    protected function stringOf($arg) {
      return is_string($arg) ? $arg : xp::stringOf($arg);
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
