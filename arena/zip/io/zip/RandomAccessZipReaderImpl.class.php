<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.zip.AbstractZipReaderImpl', 'io.streams.Seekable');

  /**
   * Zip archive reader that works on Seekable input streams.
   *
   */
  class RandomAccessZipReaderImpl extends AbstractZipReaderImpl {
    protected $skip= 0;

    /**
     * Creation constructor
     *
     * @param   io.streams.InputStream stream
     */
    public function __construct(InputStream $stream) {
      parent::__construct(cast($stream, 'io.streams.Seekable'));
    }
    
    public function firstEntry() {
      $this->stream->seek(0, SEEK_SET);
      return $this->currentEntry();
    }
    
    public function nextEntry() {
      $this->skip && $this->stream->seek($this->skip, SEEK_CUR);
      return $this->currentEntry();
    }
    
    public function currentEntry() {
      $type= $this->stream->read(4);
      switch ($type) {
        case self::FHDR: {      // Entry
          $header= $this->readLocalFileHeader();
          $this->skip= $header['compressed'];
          return new ZipFileEntry($header['name'], $this->dateFromDosDateTime($header['date'], $header['time']));
        }
        case self::DHDR: {      // Zip directory
          return NULL;          // XXX: For the moment, ignore directory and stop here
          break;
        }
        case self::EOCD: {      // End of central directory
          return NULL;
          break;
        }
        default: {
          throw new FormatException('Unknown byte sequence '.addcslashes($type, "\0..\17"));
        }
      }
      return NULL;
    }
  }
?>
