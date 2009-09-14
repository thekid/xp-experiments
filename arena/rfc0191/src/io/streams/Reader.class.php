<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.InputStream');

  /**
   * Abstract base class for all other readers
   *
   */
  abstract class Reader extends Object {
    protected $stream= NULL;
    
    /**
     * Constructor. Creates a new Reader from an InputStream.
     *
     * @param   io.streams.InputStream stream
     */
    public function __construct(InputStream $stream) {
      $this->stream= $stream;
    }
    
    /**
     * Returns the underlying stream
     *
     * @return  io.streams.InputStream stream
     */
    public function getStream() {
      return $this->stream;
    }
  }
?>