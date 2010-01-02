<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.zip.AbstractZipReaderImpl', 'io.streams.Seekable');

  /**
   * Zip archive reader that works on any input stream.
   *
   */
  class SequentialZipReaderImpl extends AbstractZipReaderImpl {
    protected $skip= 0;
    private $initial= TRUE;

    public function firstEntry() {
      if (!$this->initial) {
        throw new IllegalStateException('Stream not rewindable');
      }
      $this->initial= FALSE;
      return $this->currentEntry();
    }
    
    public function nextEntry() {
      $this->skip && $this->stream->read($this->skip);
      return $this->currentEntry();
    }
  }
?>
