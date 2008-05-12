<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.Enum', 'Profileable');

  /**
   * Unicode escapes profiling
   *
   * @purpose  Profiling
   */
  abstract class UnicodeEscapes extends Enum implements Profileable {
    const 
      INPUT_STRING  = 'Euro symbol= -\u20ac-',
      OUTPUT_STRING = "Euro symbol= -\xE2\x82\xAC-";

    public static
      $regexeval,
      $tokenizeiconv,
      $tokenize;
    
    static function __static() {
      self::$regexeval= newinstance(__CLASS__, array(0, 'regexeval'), '{
        static function __static() { }

        protected function replace($str) {
          return preg_replace(
            "/\\\\\\[u]([0-9A-F]{4})/ie",    // Three slashes in double-quoted string
            "iconv(\"ucs-4be\", \"utf-8\", pack(\"N\", hexdec(\"\$1\")))", 
            $str
          );
        }
      }');
      self::$tokenizeiconv= newinstance(__CLASS__, array(1, 'tokenizeiconv'), '{
        static function __static() { }

        protected function replace($str) {
          $t= strtok($str, "\\\\");
          $b= "";
          do {
            $b.= "u" === $t{0} 
              ? iconv("ucs-4be", "utf-8", pack("N", hexdec(substr($t, 1, 4)))).substr($t, 5)
              : $t
            ;
          } while ($t= strtok("\\\\"));
          return $b;
        }
      }');
      self::$tokenize= newinstance(__CLASS__, array(2, 'tokenize'), '{
        static function __static() { }

        protected function replace($str) {
          $t= strtok($str, "\\\\");
          $b= "";
          do {
            if ("u" !== $t{0}) {
              $b.= $t;
            } else {
              $c= hexdec($t{1}.$t{2}.$t{3}.$t{4});
              if ($c < 0x80) {
                $b.= chr($c).substr($t, 5);
              } else if ($c < 0x800) {
                $b.= pack("n", 0x0000C080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0700 & $c) << 2).substr($t, 5);
              } else if ($c < 0x10000) {
                $int= 0x00E08080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4;
                $b.= pack("Cn", ($int & 0xFF0000) >> 16, $int & 0xFFFF).substr($t, 5);
              } else if ($c < 0x110000) {
                $b.= pack("N", 0xF0808080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4 | (0x030000 &$c) << 4 | (0x1C0000 & $c) << 6).substr($t, 5);
              }      
            }
          } while ($t= strtok("\\\\"));
          return $b;
        }
      }');
    }

    /**
     * Replace unicode escapes in strings
     *
     * @param   string str
     * @return  string
     */
    protected abstract function replace($str);
    
    /**
     * Run this method and verify it works
     *
     * @param   int times
     */
    public function run($times) {

      // Assert it works
      if (self::OUTPUT_STRING !== ($replaced= $this->replace(self::INPUT_STRING))) {
        throw new IllegalStateException(sprintf(
          'Method %s failed (expected: "%s", actual: "%s")',
          $this->name,
          addcslashes(self::OUTPUT_STRING, "\0..\37\177..\377"),
          addcslashes($replaced, "\0..\37\177..\377")
        ));
      }

      // Run loop
      for ($i= 0; $i < $times; $i++) {
        $this->replace(self::INPUT_STRING);
      }
    }
    
    
    /**
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
  }
?>
