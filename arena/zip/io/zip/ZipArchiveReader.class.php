<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.zip.RandomAccessZipReaderImpl', 'io.zip.SequentialZipReaderImpl');

  /**
   * Read from a zip file
   *
   * @see      xp://io.zip.ZipArchive#open
   * @purpose  Write to a zip archive
   */
  class ZipArchiveReader extends Object {

    /**
     * Creation constructor
     *
     * @param   io.streams.InputStream stream
     */
    public function __construct(InputStream $stream) {
      if ($stream instanceof Seekable) {
        $this->impl= new RandomAccessZipReaderImpl($stream);
      } else {
        $this->impl= new SequentialZipReaderImpl($stream);
      }
    }

    /**
     * Returns a list of all entries in this zip file
     *
     * @return  io.zip.ZipEntry[]
     */
    public function entries() {
      $entries= array();
      $entry= $this->impl->firstEntry();
      while ($entry) {
        $entries[]= $entry;
        $entry= $this->impl->nextEntry();
      }
      return $entries;
    }
  }
?>
