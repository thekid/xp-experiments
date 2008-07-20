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
      $writer     = NULL,
      $data       = NULL,
      $Compression = NULL;
    
    /**
     * Constructor
     *
     * @param   io.zip.ZipArchiveWriter writer
     * @param   io.zip.ZipFile file
     */
    public function __construct(ZipArchiveWriter $writer, ZipFile $file) {
      $this->writer= $writer;
      $this->file= $file;
      $this->Compression= Compression::$NONE;
      $this->data= '';
    }
    
    /**
     * Use a given Compression
     *
     * @param   io.zip.Compression Compression
     */
    public function setCompression(Compression $Compression) {
      $this->Compression= $Compression;
    }

    /**
     * Use a given Compression and return this stream
     *
     * @param   io.zip.Compression Compression
     * @return  io.zip.ZipFileOutputStream this stream
     */
    public function withCompression(Compression $Compression) {
      $this->Compression= $Compression;
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
      $this->writer->writeFile($this->file, $this->Compression, $this->data);
      $this->data= NULL;
    }
  }
?>
