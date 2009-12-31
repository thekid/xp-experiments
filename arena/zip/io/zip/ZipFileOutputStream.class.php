<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.OutputStream', 'io.zip.Compression');

  /**
   * Output stream for files
   *
   * @see      xp://io.zip.ZipArchiveWriter#addEntry
   * @purpose  Stream
   */
  class ZipFileOutputStream extends Object implements OutputStream {
    protected
      $writer      = NULL,
      $data        = NULL,
      $compression = NULL;
    
    /**
     * Constructor
     *
     * @param   io.zip.ZipArchiveWriter writer
     * @param   io.zip.ZipFileEntry file
     */
    public function __construct(ZipArchiveWriter $writer, ZipFileEntry $file) {
      $this->writer= $writer;
      $this->file= $file;
      $this->compression= Compression::$NONE;
      $this->data= '';
    }
    
    /**
     * Use a given compression
     *
     * @param   io.zip.Compression compression
     */
    public function setCompression(Compression $compression) {
      $this->compression= $compression;
    }

    /**
     * Use a given compression and return this stream
     *
     * @param   io.zip.Compression compression
     * @return  io.zip.ZipFileOutputStream this stream
     */
    public function withCompression(Compression $compression) {
      $this->compression= $compression;
      return $this;
    }

    /**
     * Write a string
     *
     * @param   mixed arg
     */
    public function write($arg) {
      $this->data.= $arg;
    }

    /**
     * Flush this buffer
     *
     */
    public function flush() {
      // NOOP
    }

    /**
     * Close this buffer
     *
     */
    public function close() {
      $this->writer->writeFile($this->file, $this->compression, $this->data);
      $this->data= NULL;
    }
  }
?>
