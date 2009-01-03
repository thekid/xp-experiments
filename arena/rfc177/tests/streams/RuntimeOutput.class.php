<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Output of runtime
   *
   * @see      xp://tests.streams.ChannelStreamTest
   * @purpose  Value object
   */
  class RuntimeOutput extends Object {
    protected $exitCode= 0;
    protected $out, $err;
    
    /**
     * Constructor
     *
     * @param   int exitCode
     * @param   string out
     * @param   string err
     */
    public function __construct($exitCode, $out, $err) {
      $this->exitCode= $exitCode;
      $this->out= $out;
      $this->err= $err;
    }

    /**
     * Retrieve exit code
     *
     * @return  int
     */
    public function exitCode() {
      return $this->exitCode;
    }
    
    /**
     * Retrieve standard output
     *
     * @return  string
     */
    public function out() {
      return $this->out;
    }

    /**
     * Retrieve standard error
     *
     * @return  string
     */
    public function err() {
      return $this->err;
    }
  }
?>
