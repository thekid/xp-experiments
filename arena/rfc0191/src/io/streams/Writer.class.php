<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.OutputStream');

  /**
   * Abstract base class for all other writers
   *
   */
  abstract class Writer extends Object {
    protected $stream= NULL;
    
    /**
     * Constructor. Creates a new Writer from an OutputStream.
     *
     * @param   io.streams.OutputStream stream
     */
    public function __construct(OutputStream $stream) {
      $this->stream= $stream;
    }
    
    /**
     * Returns the underlying stream
     *
     * @return  io.streams.OutputStream stream
     */
    public function getStream() {
      return $this->stream;
    }
  }
?>
