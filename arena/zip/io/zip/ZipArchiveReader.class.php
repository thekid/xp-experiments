<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.InputStream', 'io.zip.Compression', 'util.Date');

  /**
   * Read from a zip file
   *
   * @see      xp://io.zip.ZipArchive#open
   * @purpose  Write to a zip archive
   */
  class ZipArchiveReader extends Object {
    protected $stream= NULL;

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

    /**
     * Returns a list of all entries in this zip file
     *
     * @return  io.zip.ZipEntry[]
     */
    public function entries() {
      $done= FALSE;
      $r= array();
      do {
        $header= $this->stream->read(4);
        switch ($header) {
          case self::FHDR: {      // Entry
            $info= unpack(
              'vversion/vflags/vcompression/vtime/vdate/Vcrc/Vcompressed/Vuncompressed/vnamelen/vextralen', 
              $this->stream->read(26)
            );
            $name= $this->stream->read($info['namelen']);
            $extra= $this->stream->read($info['extralen']);
            $this->stream->read($info['compressed']);
            
            Console::writeLinef(
              '%s: %.2f kB / %s @ %s',
              $name, 
              $info['uncompressed'] / 1024,
              Compression::getInstance($info['compression'])->name(),
              $this->dateFromDosDateTime($info['date'], $info['time'])->toString('Y-m-d H:i:s')
            );
            $r[]= new ZipFileEntry($name, $this->dateFromDosDateTime($info['date'], $info['time']));
            break;
          }
          case self::DHDR: {      // Zip directory
            $done= TRUE;
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
      return $r;
    }
  }
?>
