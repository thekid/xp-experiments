<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses('io.streams.InputStream', 'io.zip.Compression');

  /**
   * Zip File input stream
   *
   * @purpose  InputStream implementation
   */
  class ZipFileInputStream extends Object implements InputStream {
    protected 
      $reader      = NULL,
      $pos         = 0,
      $length      = 0,
      $compression = NULL;

    /**
     * Constructor
     *
     * @param   io.zip.AbstractZipReaderImpl reader
     * @param   io.zip.Compression compression
     * @param   int length
     */
    public function __construct(AbstractZipReaderImpl $reader, Compression $compression, $length) {
      $this->reader= $reader;
      $this->compression= $compression;
      $this->length= $length;
    }

    /**
     * Read a string
     *
     * @param   int limit default 8192
     * @return  string
     */
    public function read($limit= 8192) {
      if ($this->pos >= $this->length) {
        throw new IOException('EOF');
      }
      $data= '';
      while ($this->available() > 0) {
        $chunk= $this->reader->streamRead($this->length- $this->pos);
        $read= strlen($chunk);
        $this->pos+= $read;
        $this->reader->skip-= $read;
        $data.= $chunk;
      }
      return $this->compression->decompress($data);
    }

    /**
     * Returns the number of bytes that can be read from this stream 
     * without blocking.
     *
     */
    public function available() {
      return $this->pos < $this->length ? $this->reader->streamAvailable() : 0;
    }

    /**
     * Close this buffer
     *
     */
    public function close() {
      // NOOP, leave
    }
  }
?>
