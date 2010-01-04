<?php
/* This class is part of the XP framework
 *
 * $Id: Compression.class.php 11831 2010-01-02 12:58:24Z friebe $ 
 */

  uses(
    'lang.Enum', 
    'io.streams.InputStream', 
    'io.streams.InflatingInputStream',
    'io.streams.DeflatingOutputStream',
    'io.streams.Bz2DecompressingInputStream',
    'io.streams.Bz2CompressingOutputStream'
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
        
        protected function getCompressionStream0($stream, $level) {
          return $stream;
        }

        protected function getDecompressionStream0($stream) {
          return $stream;
        }
      }');
      self::$GZ= newinstance(__CLASS__, array(8, 'GZ'), '{
        static function __static() { }
        
        protected function getCompressionStream0($stream, $level) {
          return new DeflatingOutputStream($stream, $level);
        }

        protected function getDecompressionStream0($stream) {
          return new InflatingInputStream($stream);
        }
      }');
      self::$BZ= newinstance(__CLASS__, array(12, 'BZ'), '{
        static function __static() { }
        
        protected function getCompressionStream0($stream, $level) {
          return new Bz2CompressingOutputStream($stream, $level);
        }

        protected function getDecompressionStream0($stream) {
          return new Bz2DecompressingInputStream($stream);
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
     * Gets compression stream
     *
     * @param   io.streams.OutputStream out
     * @param   int level default 6 the compression level
     * @return  io.streams.OutputStream
     * @throws  lang.IllegalArgumentException if the level is not between 0 and 9
     */
    public function getCompressionStream(OutputStream $out, $level= 6) {
      if ($level < 0 || $level > 9) {
        throw new IllegalArgumentException('Level '.$level.' out of range [0..9]');
      }
      return $this->getCompressionStream0($out, $level);
    }

    /**
     * Gets compression stream. Implemented in members.
     *
     * @param   io.streams.OutputStream stream
     * @param   int level the compression level
     * @return  io.streams.OutputStream
     */
    protected abstract function getCompressionStream0($stream, $level);

    /**
     * Gets decompression stream.
     *
     * @param   io.streams.InputStream in
     * @return  io.streams.InputStream
     */
    public function getDecompressionStream(InputStream $in) {
      return $this->getDecompressionStream0($in);
    }

    /**
     * Gets decompression stream. Implemented in members.
     *
     * @param   io.streams.InputStream stream
     * @return  io.streams.InputStream
     */
    protected abstract function getDecompressionStream0($stream);

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
