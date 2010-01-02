<?php
/* This class is part of the XP framework
 *
 * $Id: ZipFileOutputStream.class.php 11849 2010-01-02 15:09:20Z friebe $ 
 */

  uses('io.streams.OutputStream', 'io.archive.zip.Compression');

  /**
   * Output stream for files
   *
   * @see      xp://io.archive.zip.ZipArchiveWriter#addEntry
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
     * @param   io.archive.zip.ZipArchiveWriter writer
     * @param   io.archive.zip.ZipFileEntry file
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
     * @param   io.archive.zip.Compression compression
     */
    public function setCompression(Compression $compression) {
      $this->compression= $compression;
    }

    /**
     * Use a given compression and return this stream
     *
     * @param   io.archive.zip.Compression compression
     * @return  io.archive.zip.ZipFileOutputStream this stream
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
      if (NULL === $this->data) return;     // Already written

      $this->writer->writeFile($this->file, $this->compression, $this->data);
      $this->data= NULL;
    }
  }
?>
