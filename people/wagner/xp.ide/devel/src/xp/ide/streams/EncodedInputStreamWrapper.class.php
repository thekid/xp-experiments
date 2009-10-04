<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.streams';
  
  uses(
    'xp.ide.streams.IEncodedInputStream'
  );
  
  /**
   * channel input stream with encoding meta information
   *
   * @purpose  IDE
   */
  class xp·ide·streams·EncodedInputStreamWrapper extends Object implements xp·ide·streams·IEncodedInputStream {
    private
      $encoding= xp·ide·streams·IEncodedInputStream::ENCODING_NONE,
      $stream= NULL;

    /**
     * Constructor
     *
     * @param   io.streams.InputStream stream
     */
    public function __construct(InputStream $stream) {
      $this->stream= $stream;
    }

    /**
     * set stream
     *
     * @param   io.stream.InputStream stream
     */
    public function setStream(InputStream $stream) {
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
      return $this->stream->close();
    }

    /**
     * Set encoding
     *
     * @param   string encoding
     */
    public function setEncoding($encoding) {
      $this->encoding= $encoding;
    }

    /**
     * Get encoding
     *
     * @param   string
     */
    public function getEncoding() {
      return $this->encoding;
    }

  }
?>
