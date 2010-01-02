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
    protected $entries= NULL;

    /**
     * Returns a list of all entries in this zip file
     *
     * @return  io.zip.ZipEntry[]
     */
    public function entries() {
      if (NULL !== $this->entries) return $this->entries;
      
      $done= FALSE;
      $this->entries= array();
      do {
        $header= $this->stream->read(4);
        switch ($header) {
          case self::FHDR: {      // Entry
            $header= $this->readLocalFileHeader();
            $this->stream->read($header['compressed']);
            $this->entries[]= new ZipFileEntry($name, $this->dateFromDosDateTime($info['date'], $info['time']));
            break;
          }
          case self::DHDR: {      // Zip directory
            $done= TRUE;          // XXX: For the moment, ignore directory and stop here
            break;
          }
          case self::EOCD: {      // End of central directory
            $done= TRUE;
            break;
          }
          default: {
            throw new FormatException('Unknown byte sequence '.addcslashes($header, "\0..\17"));
          }
        }
      } while (!$done);
      return $this->entries;
    }
  }
?>
