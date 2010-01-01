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

    /**
     * Creation constructor
     *
     * @param   io.streams.InputStream stream
     */
    public function __construct(InputStream $stream) {
      parent::__construct(cast($stream, 'io.streams.Seekable'));
    }
    
    /**
     * Returns a list of all entries in this zip file
     *
     * @return  io.zip.ZipEntry[]
     */
    public function entries() {
      $done= FALSE;
      $r= array();
      $this->stream->seek(0, SEEK_SET);
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
            $this->stream->seek($info['compressed'], SEEK_CUR);
            
            /*
              Console::writeLinef(
                '%s: %.2f kB / %s @ %s',
                $name, 
                $info['uncompressed'] / 1024,
                Compression::getInstance($info['compression'])->name(),
                $this->dateFromDosDateTime($info['date'], $info['time'])->toString('Y-m-d H:i:s')
              );
            */
            $r[]= new ZipFileEntry($name, $this->dateFromDosDateTime($info['date'], $info['time']));
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
      return $r;
    }
  }
?>
