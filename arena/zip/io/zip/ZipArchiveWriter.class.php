<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.zip.ZipEntry', 'io.zip.Compression', 'io.zip.ZipFileOutputStream');


  /**
   * Writes to a ZIP archive
   *
   * @see      xp://io.zip.ZipArchive#create
   * @purpose  Write to a zip archive
   */
  class ZipArchiveWriter extends Object {
    protected
      $stream   = NULL,
      $dir      = array(), 
      $pointer  = 0,
      $out      = NULL;

    const EOCD = "\x50\x4b\x05\x06\x00\x00\x00\x00";
    const FHDR = "\x50\x4b\x03\x04\x0a\x00\x00\x00";
    const DHDR = "\x50\x4b\x01\x02\x14\x0b\x0a\x00";

    /**
     * Creation constructor
     *
     * @param   io.streams.OutputStream stream
     */
    public function __construct(OutputStream $stream) {
      $this->stream= $stream;
    }

    /**
     * Adds a directory entry
     *
     * @param   io.zip.ZipDirEntry entry
     * @return  io.zip.ZipDirEntry the added directory
     * @throws  lang.IllegalArgumentException in case the filename is longer than 65535 bytes
     */
    public function addDir(ZipDirEntry $entry) {
      if (strlen($entry->getName()) > 0xFFFF) {
        throw new IllegalArgumentException('Filename too long ('.$nameLength.')');
      }

      $this->out && $this->out->close();
      $this->out= NULL;
      
      $mod= $entry->lastModified();
      $name= $entry->getName();
      $nameLength= strlen($name);
      $extraLength= 0;
      $extra= '';
      
      $info= pack(
        'vvvVVVvv',
        0,                        // compression method
        $this->dosTime($mod),     // last modified dostime
        $this->dosDate($mod),     // last modified dosdate
        0,                        // CRC32 checksum
        0,                        // compressed size
        0,                        // uncompressed size
        $nameLength,              // filename length
        $extraLength              // extra field length
      );

      $this->stream->write(self::FHDR.$info.$name.$extra);
      
      $this->dir[$name]= array('info' => $info, 'pointer' => $this->pointer, 'type' => 0x10);
      $this->pointer+= (
        strlen(self::FHDR) + 
        strlen($info) + 
        $nameLength
      );
      
      return $entry;
    }

    /**
     * Adds a file entry
     *
     * @param   io.zip.ZipFileEntry entry
     * @return  io.zip.ZipFileOutputStream
     * @throws  lang.IllegalArgumentException in case the filename is longer than 65535 bytes
     */
    public function addFile(ZipFileEntry $entry) {
      if (strlen($entry->getName()) > 0xFFFF) {
        throw new IllegalArgumentException('Filename too long ('.$nameLength.')');
      }

      $this->out && $this->out->close();
      $this->out= new ZipFileOutputStream($this, $entry);
      return $this->out;
    }
    
    /**
     * Returns a time in the format used by MS-DOS.
     *
     * @see     http://www.vsft.com/hal/dostime.htm
     * @param   util.Date date
     * @return  int
     */
    protected function dosTime(Date $date) {
      return 
        (((($date->getHours() & 0x1F) << 6) | ($date->getMinutes() & 0x3F)) << 5) | 
        ((int)($date->getSeconds() / 2) & 0x1F)
      ;
    }

    /**
     * Returns a date in the format used by MS-DOS.
     *
     * @see     http://www.vsft.com/hal/dostime.htm
     * @param   util.Date date
     * @return  int
     */
    protected function dosDate(Date $date) {
      return
        ((((($date->getYear() - 1980) & 0x7F) << 4) | ($date->getMonth() & 0x0F)) << 5) |
        ($date->getDay() & 0x1F)
      ;
    }
    
    /**
     * Write a file entry
     *
     * @param   io.zip.ZipFile file
     * @param   io.zip.Compression compression
     * @param   string data
     */
    public function writeFile(ZipFileEntry $file, Compression $compression, $data) {
      $mod= $file->lastModified();
      $name= str_replace('\\', '/', $file->getName());
      $nameLength= strlen($name);
      $crc32= crc32($data);
      $compressionMethod= $compression->ordinal();
      $compressed= $compression->compress($data);
      $compressedLength= strlen($compressed);
      $extraLength= 0;
      $extra= '';

      $info= pack(
        'vvvVVVvv',
        $compressionMethod,       // compression method, 0 = none, 8 = gz, 12 = bz
        $this->dosTime($mod),     // last modified dostime
        $this->dosDate($mod),     // last modified dosdate
        $crc32,                   // CRC32 checksum
        $compressedLength,        // compressed size
        strlen($data),            // uncompressed size
        $nameLength,              // filename length
        $extraLength              // extra field length
      );

      $this->stream->write(self::FHDR.$info.$name.$extra);
      $this->stream->write($compressed);
      
      $this->dir[$name]= array('info' => $info, 'pointer' => $this->pointer, 'type' => 0x20);
      $this->pointer+= (
        strlen(self::FHDR) + 
        strlen($info) + 
        $nameLength + 
        $compressedLength
      );
    }

    /**
     * Closes this zip archive
     *
     */
    public function close() {
      $this->out && $this->out->close();

      $comment= '';
      
      // Build central directory
      $l= 0;
      foreach ($this->dir as $name => $entry) {
        $s= (
          self::DHDR.
          "\x00\x00".           // general purpose bit flag
          $entry['info'].       // { see writeFile() }
          "\x00\x00".           // file comment length
          "\x00\x00".           // disk number start
          "\x01\x00".           // internal file attributes
          pack('V', $entry['type']).
          pack('V', $entry['pointer']).
          $name
        );
        $l+= strlen($s);
        $this->stream->write($s);
      }
      
      // End of central directory
      $this->stream->write(self::EOCD);
      $this->stream->write(pack(
        'vvVVv', 
        sizeof($this->dir),     // total #entries in central dir on this disk
        sizeof($this->dir),     // total #entries in central dir
        $l,                     // size of central dir
        $this->pointer,         // offset of start of central directory with respect to the starting disk number
        strlen($comment)
      ));
      $this->stream->write($comment);
    }
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'('.$this->stream->toString().")@{\n";
      foreach ($this->dir as $name => $entry) {
        $s.= '  dir{'.dechex($entry['type']).': "'.$name.'" @ '.$entry['pointer']."}\n";
      }
      return $s.'}';
    }
  }
?>
