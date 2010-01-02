<?php
/* This class is part of the XP framework
 *
 * $Id: Compression.class.php 11831 2010-01-02 12:58:24Z friebe $ 
 */

  uses('lang.Enum');

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

        protected function doDecompress($data) {
          return $data;
        }
      }');
      self::$GZ= newinstance(__CLASS__, array(8, 'GZ'), '{
        static function __static() { }
        
        protected function doCompress($data, $level) {
          return gzdeflate($data, $level);
        }

        protected function doDecompress($data) {
          return gzinflate($data);
        }
      }');
      self::$BZ= newinstance(__CLASS__, array(12, 'BZ'), '{
        static function __static() { }
        
        protected function doCompress($data, $level) {
          return bzcompress($data, $level);
        }

        protected function doDecompress($data) {
          return bzdecompress($data);
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
     * Decompresses data
     *
     * @param   string compressed The compressed data
     * @return  string data
     */
    public function decompress($compressed) {
      return $this->doDecompress($compressed);
    }


    /**
     * Decompresses data. Implemented in members.
     *
     * @param   string compressed The compressed data
     * @return  string data
     */
    protected abstract function doDecompress($data);
    
    /**
     * (Insert method's description here)
     *
     * @param   int n
     * @return  
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