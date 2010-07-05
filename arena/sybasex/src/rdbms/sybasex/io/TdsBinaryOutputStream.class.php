<?php
/* This file is part of the XP framework's experiments
 *
 * $Id$
 */

  uses('io.streams.OutputStream');

  /**
   * TdsBinaryOutputStream facilitates writing the
   * TDS protocol to the net.
   *
   * @purpose  OutputStream implementation
   */
  class TdsBinaryOutputStream extends Object implements OutputStream {
    protected
      $stream= NULL;
    
    /**
     * Constructor
     *
     * @param   io.streams.OutputStream
     */
    public function __construct(OutputStream $stream) {
      $this->stream= $stream;
    }

    /**
     * Write a string
     *
     * @param   var arg
     */
    public function write($arg) {
      $this->stream->write($arg);
    }

    /**
     * Flush this buffer
     *
     */
    public function flush() {
      $this->stream->flush();
    }

    /**
     * Close this buffer
     *
     */
    public function close() {
      $this->stream->close();
    }

    /**
     * Creates a string representation of this output strean
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->stream->toString().'>';
    }
  }
?>
