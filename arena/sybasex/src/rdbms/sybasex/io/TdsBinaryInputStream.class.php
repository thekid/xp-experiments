<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.InputStream');

  /**
   * Wrapping InputStream with facility methods
   * for easier binary reading
   *
   * @purpose  InputStream implementation
   */
  class TdsBinaryInputStream extends Object implements InputStream {
    protected
      $stream   = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct(InputStream $stream) {
      $this->stream= $stream;
    }
    
    /**
     * Read a string
     *
     * @param   int limit default 8192
     * @return  string
     */
    public function read($limit= 8192) {
      return $this->stream->read($limit);
    }

    /**
     * Returns the number of bytes that can be read from this stream 
     * without blocking.
     *
     */
    public function available() {
      return $this->stream->available();
    }

    /**
     * Close this buffer
     *
     */
    public function close() {
      $this->stream->close();
    }

    /**
     * Creates a string representation of this input stream
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->stream->toString().'>';
    }
  }
?>
