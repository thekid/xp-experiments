<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.streams.InputStream', 
    'io.zip.Compression', 
    'util.Date'
  );

  /**
   * Abstract base class for zip reader implementations
   *
   * @ext   iconv
   */
  abstract class AbstractZipReaderImpl extends Object {
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
     * Read local file header
     *
     * @return  array<string, var>
     */
    protected function readLocalFileHeader() {
      $header= unpack(
        'vversion/vflags/vcompression/vtime/vdate/Vcrc/Vcompressed/Vuncompressed/vnamelen/vextralen', 
        $this->stream->read(26)
      );
      $header['name']= iconv('cp437', 'iso-8859-1', $this->stream->read($header['namelen']));
      $header['extra']= $this->stream->read($header['extralen']);

      Console::writeLinef(
        '- %s: %.2f kB / %s @ %s',
        $name, 
        $header['uncompressed'] / 1024,
        Compression::getInstance($header['compression'])->name(),
        $this->dateFromDosDateTime($header['date'], $header['time'])->toString('Y-m-d H:i:s')
      );
      Console::writeLine(xp::stringOf($header));
      return $header;
    }
    
    /**
     * Returns a list of all entries in this zip file
     *
     * @return  io.zip.ZipEntry[]
     */
    public abstract function entries();
  }
?>
