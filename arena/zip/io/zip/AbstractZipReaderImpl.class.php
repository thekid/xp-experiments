<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.streams.InputStream', 
    'io.streams.ZipFileInputStream', 
    'io.zip.Compression',
    'io.zip.ZipDirEntry',
    'io.zip.ZipFileEntry',
    'util.Date'
  );

  /**
   * Abstract base class for zip reader implementations
   *
   * @ext   iconv
   */
  abstract class AbstractZipReaderImpl extends Object {
    protected $stream= NULL;
    public $skip= 0;

    const EOCD = "\x50\x4b\x05\x06";
    const FHDR = "\x50\x4b\x03\x04";
    const DHDR = "\x50\x4b\x01\x02";

    /**
     * Creation constructor
     *
     * @param   io.streams.InputStream stream
     */
    public function __construct(InputStream $stream) {
      $this->stream= $stream;
    }

    /**
     * Creates a date from DOS date and time
     *
     * @see     http://www.vsft.com/hal/dostime.htm
     * @param   int date
     * @param   int time
     * @return  util.Date
     */
    protected function dateFromDosDateTime($date, $time) {
      return Date::create(
        (($date >> 9) & 0x7F) + 1980,
        (($date >> 5) & 0x0F),
        $date & 0x1F,
        ($time >> 11) & 0x1F,
        ($time >> 5) & 0x3F,
        ($time << 1) & 0x1E
      );
    }
    
    public function streamAvailable() {
      return $this->stream->available();
    }

    public function streamRead($limit) {
      return $this->stream->read($limit);
    }

    /**
     * Get first entry
     *
     * @return  io.zip.ZipEntry
     */
    public abstract function firstEntry();
    
    /**
     * Get next entry
     *
     * @return  io.zip.ZipEntry
     */
    public abstract function nextEntry();

    /**
     * Gets current entry
     *
     * @return  io.zip.ZipEntry
     */
    public function currentEntry() {
      $type= $this->stream->read(4);
      switch ($type) {
        case self::FHDR: {      // Entry
          $header= unpack(
            'vversion/vflags/vcompression/vtime/vdate/Vcrc/Vcompressed/Vuncompressed/vnamelen/vextralen', 
            $this->stream->read(26)
          );
          $name= iconv('cp437', 'iso-8859-1', $this->stream->read($header['namelen']));
          $extra= $this->stream->read($header['extralen']);
          $date= $this->dateFromDosDateTime($header['date'], $header['time']);

          Console::writeLinef(
            '- %s: %.2f kB / %s @ %s',
            $name, 
            $header['uncompressed'] / 1024,
            Compression::getInstance($header['compression'])->name(),
            $date->toString('Y-m-d H:i:s')
          );
          Console::writeLine(xp::stringOf($header));

          $this->skip= $header['compressed'];
          if ('/' === substr($name, -1)) {
            return new ZipDirEntry($name, $date);
          } else {
            $e= new ZipFileEntry($name, $date);
            $e->is= new ZipFileInputStream(
              $this, 
              Compression::getInstance($header['compression']),
              $header['compressed']
            );
            return $e;
          }
        }
        case self::DHDR: {      // Zip directory
          return NULL;          // XXX: For the moment, ignore directory and stop here
        }
        case self::EOCD: {      // End of central directory
          return NULL;
        }
      }
      throw new FormatException('Unknown byte sequence '.addcslashes($type, "\0..\17"));
    }
  }
?>
