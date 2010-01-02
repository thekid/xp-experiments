<?php
/* This class is part of the XP framework
 *
 * $Id: Compression.class.php 11831 2010-01-02 12:58:24Z friebe $ 
 */

  uses(
    'lang.Enum', 
    'io.streams.InputStream', 
    'io.streams.InflatingInputStream'
  );

  /**
   * Compression algorithm enumeration
   *
   * @ext      bz2
   * @ext      zlib
   * @see      xp://io.archive.zip.ZipArchive
   * @purpose  Compressions
   */
  abstract class Compression extends Enum {
    public static $NONE, $GZ, $BZ;
    
    static function __static() {
      self::$NONE= newinstance(__CLASS__, array(0, 'NONE'), '{
        static function __static() { }
        
        protected function doCompress($data, $level) {
          return $data;
        }

        public function getDecompressionStream(InputStream $stream) {
          return $stream;
        }
      }');
      self::$GZ= newinstance(__CLASS__, array(8, 'GZ'), '{
        static function __static() { }
        
        protected function doCompress($data, $level) {
          return gzdeflate($data, $level);
        }

        public function getDecompressionStream(InputStream $stream) {
          return new InflatingInputStream($stream);
        }
      }');
      self::$BZ= newinstance(__CLASS__, array(12, 'BZ'), '{
        static function __static() { }
        
        protected function doCompress($data, $level) {
          return bzcompress($data, $level);
        }

        public function getDecompressionStream(InputStream $stream) {
          // Not yet implemented
        }
      }');
    }
    
    /**
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }

    /**
     * Compresses data
     *
     * @param   string data The data to be compressed
     * @param   int level default 6 the compression level
     * @return  string compress
     */
    public function compress($data, $level= 6) {
      if ($level < 0 || $level > 9) {
        throw new IllegalArgumentException('Level '.$level.' out of range [0..9]');
      }
      return $this->doCompress($data, $level);
    }

    /**
     * Compresses data. Implemented in members.
     *
     * @param   string data The data to be compressed
     * @param   int level the compression level
     * @return  string compress
     */
    protected abstract function doCompress($data, $level);

    /**
     * Gets decompression stream. Implemented in members.
     *
     * @param   io.streams.InputStream
     * @return  io.streams.InputStream
     */
    public abstract function getDecompressionStream(InputStream $in);

    /**
     * Get a compression instance by a given id
     *
     * @param   int n
     * @return  io.archive.zip.Compression
     * @throws  lang.IllegalArgumentException
     */
    public static function getInstance($n) {
      switch ($n) {
        case 0: return self::$NONE;
        case 8: return self::$GZ;
        case 12: return self::$BZ;
        default: throw new IllegalArgumentException('Unknown compression algorithm #'.$n);
      }
    }
  }
?>
