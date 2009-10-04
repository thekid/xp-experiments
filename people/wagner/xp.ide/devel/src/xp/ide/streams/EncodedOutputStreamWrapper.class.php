<?php
/* This class is part of the XP framework
 *
 * $Id: ChannelInputStream.class.php 11317 2009-08-07 12:34:15Z ruben $ 
 */
  $package= 'xp.ide.streams';

  uses(
    'xp.ide.streams.IEncodedOutputStream'
  );

  /**
   * channel input stream with encoding meta information
   *
   * @purpose  IDE
   */
  class xp·ide·streams·EncodedOutputStreamWrapper extends Object implements xp·ide·streams·IEncodedOutputStream {
    private
      $encoding= xp·ide·streams·IEncodedOutputStream::ENCODING_NONE,
      $stream= NULL;

    /**
     * Constructor
     *
     * @param   io.streams.OutputStream stream
     */
    public function __construct(OutputStream $stream) {
      $this->stream= $stream;
    }

    /**
     * set stream
     *
     * @param   io.streams.OutputStream stream
     */
    public function setStream(OutputStream $stream) {
      $this->stream= $stream;
    }

    /**
     * set stream
     *
     * @return  io.streams.OutputStream stream
     */
    public function getStream() {
      return $this->stream;
    }

    /**
     * Write a string
     *
     * @param   mixed arg
     */
    public function write($arg) {
      return $this->stream->write($arg);
    }

    /**
     * Flush this buffer
     *
     */
    public function flush() {
      return $this->stream->flush();
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
