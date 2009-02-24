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
      INPUT_STRING  = '\\Euro symbol= -\u20ac-\n',
      OUTPUT_STRING = "\\Euro symbol= -\xE2\x82\xAC-\\n";

    public static
      $regexeval,
      $tokenizeiconv,
      $tokenizeiconvss,
      $tokenize,
      $tokenizenp,
      $tokenizess,
      $pos,
      $split,
      $strcspn;
    
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
              : "\\\\".$t
            ;
          } while ($t= strtok("\\\\"));
          return "\\\\" === $str{0} ? $b : substr($b, 1);
        }
      }');
      self::$tokenizeiconvss= newinstance(__CLASS__, array(2, 'tokenizeiconvss'), '{
        static function __static() { }

        protected function replace($str) {
          $t= strtok($str, "\\\\");
          $b= "";
          do {
            if ("u" === $t{0}) {
              sscanf($t, "u%4X%[^\]", $c, $r);
              $b.= iconv("ucs-4be", "utf-8", pack("N", $c)).$r;
            } else {
              $b.= "\\\\".$t;
            }
          } while ($t= strtok("\\\\"));
          return "\\\\" === $str{0} ? $b : substr($b, 1);
        }
      }');
      self::$tokenize= newinstance(__CLASS__, array(3, 'tokenize'), '{
        static function __static() { }

        protected function replace($str) {
          $t= strtok($str, "\\\\");
          $b= "";
          do {
            if ("u" !== $t{0}) {
              $b.= "\\\\".$t;
            } else {
              $c= hexdec(substr($t, 1, 4));
              if ($c < 0x80) {
                $b.= chr($c);
              } else if ($c < 0x800) {
                $b.= pack("n", 0x0000C080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0700 & $c) << 2);
              } else if ($c < 0x10000) {
                $i= 0x00E08080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4;
                $b.= pack("Cn", ($i & 0xFF0000) >> 16, $i & 0xFFFF);
              } else if ($c < 0x110000) {
                $b.= pack("N", 0xF0808080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4 | (0x030000 &$c) << 4 | (0x1C0000 & $c) << 6);
              }     
              $b.= substr($t, 5); 
            }
          } while ($t= strtok("\\\\"));
          return "\\\\" === $str{0} ? $b : substr($b, 1);
        }
      }');
      self::$tokenizenp= newinstance(__CLASS__, array(4, 'tokenizenp'), '{
        static function __static() { }

        protected function replace($str) {
          static $chr= NULL;
          if (!$chr) {
            for ($i= 0; $i < 256; $i++) $chr.= chr($i);
          }
          
          $t= strtok($str, "\\\\");
          $b= "";
          do {
            if ("u" !== $t{0}) {
              $b.= "\\\\".$t;
            } else {
              $c= hexdec($t{1}.$t{2}.$t{3}.$t{4});
              if ($c < 0x80) {
                $b.= $chr{$c};
              } else if ($c < 0x800) {
                $i= 0x0000C080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0700 & $c) << 2;
                $b.= $chr{(int)($i / 256)}.$chr{$i % 256};
              } else if ($c < 0x10000) {
                $int= 0x00E08080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4;
                $b.= $chr{($int & 0xFF0000) >> 16}.$chr{(int)(($int & 0xFFFF) / 256)}.$chr{($int & 0xFFFF) % 256};
              } else if ($c < 0x110000) {
                $i= 0xF0808080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4 | (0x030000 &$c) << 4 | (0x1C0000 & $c) << 6;
                $b.= $chr{(int)($i / 16777216) % 16777216}.$chr{(int)($i / 65536) % 65536}.$chr{(int)($i / 256) % 256}.$chr{$i % 256};
              }      
              $b.= substr($t, 5); 
            }
          } while ($t= strtok("\\\\"));
          return "\\\\" === $str{0} ? $b : substr($b, 1);
        }
      }');
      self::$tokenizess= newinstance(__CLASS__, array(5, 'tokenizess'), '{
        static function __static() { }

        protected function replace($str) {
          static $chr= NULL;
          if (!$chr) {
            for ($i= 0; $i < 256; $i++) $chr.= chr($i);
          }
          
          $t= strtok($str, "\\\\");
          $b= "";
          do {
            if ("u" !== $t{0}) {
              $b.= "\\\\".$t;
            } else {
              sscanf($t, "u%4X%[^\]", $c, $r);
              if ($c < 0x80) {
                $b.= $chr{$c};
              } else if ($c < 0x800) {
                $i= 0x0000C080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0700 & $c) << 2;
                $b.= $chr{(int)($i / 256)}.$chr{$i % 256};
              } else if ($c < 0x10000) {
                $int= 0x00E08080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4;
                $b.= $chr{($int & 0xFF0000) >> 16}.$chr{(int)(($int & 0xFFFF) / 256)}.$chr{($int & 0xFFFF) % 256};
              } else if ($c < 0x110000) {
                $i= 0xF0808080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4 | (0x030000 &$c) << 4 | (0x1C0000 & $c) << 6;
                $b.= $chr{(int)($i / 16777216) % 16777216}.$chr{(int)($i / 65536) % 65536}.$chr{(int)($i / 256) % 256}.$chr{$i % 256};
              }      
              $b.= $r; 
            }
          } while ($t= strtok("\\\\"));
          return "\\\\" === $str{0} ? $b : substr($b, 1);
        }
      }');
      self::$pos= newinstance(__CLASS__, array(6, 'pos'), '{
        static function __static() { }

        protected function replace($str) {
          $out= "";
          $offset= 0;
          while (FALSE !== ($p= strpos($str, "\\\\", $offset))) {
            if ("u" !== $str{$p+ 1}) {
              $out.= substr($str, $offset, $p+ 1);
              $offset= $p+ 1;
            } else {
              $out.= substr($str, $offset, $p- 1);
              $offset= $p+ 6;
              $c= hexdec(substr($str, $p+ 2, 4));
              if ($c < 0x80) {
                $out.= chr($c);
              } else if ($c < 0x800) {
                $out.= pack("n", 0x0000C080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0700 & $c) << 2);
              } else if ($c < 0x10000) {
                $i= 0x00E08080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4;
                $out.= pack("Cn", ($i & 0xFF0000) >> 16, $i & 0xFFFF);
              } else if ($c < 0x110000) {
                $out.= pack("N", 0xF0808080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4 | (0x030000 &$c) << 4 | (0x1C0000 & $c) << 6);
              }     
            }
          }
          return $out;
        }
      }');
      self::$split= newinstance(__CLASS__, array(7, 'split'), '{
        static function __static() { }

        protected function replace($str) {
          $out= "";
          foreach (explode("\\\\", $str) as $token) {
            if ("" === $token) {
              // NOOP
            } else if ("u" !== $token{0}) {
              $out.= "\\\\".$token;
            } else {
              $c= hexdec(substr($token, 1, 4));
              if ($c < 0x80) {
                $out.= chr($c);
              } else if ($c < 0x800) {
                $out.= pack("n", 0x0000C080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0700 & $c) << 2);
              } else if ($c < 0x10000) {
                $i= 0x00E08080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4;
                $out.= pack("Cn", ($i & 0xFF0000) >> 16, $i & 0xFFFF);
              } else if ($c < 0x110000) {
                $out.= pack("N", 0xF0808080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4 | (0x030000 &$c) << 4 | (0x1C0000 & $c) << 6);
              }
              $out.= substr($token, 5);
            }
          }
          return $out;
        }
      }');
      self::$strcspn= newinstance(__CLASS__, array(8, 'strcspn'), '{
        static function __static() { }

        protected function replace($str) {
          $out= "";
          $offset= 0;
          while (FALSE !== ($l= strcspn($str, "\\\\", $offset))) {
            $l++;
            if ("u" !== $str{$offset+ $l}) {
              $out.= substr($str, $offset, $l);
              $offset+= $l;
            } else {
              $out.= substr($str, $offset, $l- 1);
              $c= hexdec(substr($str, $offset+ $l+ 1, 4));
              $offset+= $l+ 5;
              if ($c < 0x80) {
                $out.= chr($c);
              } else if ($c < 0x800) {
                $out.= pack("n", 0x0000C080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0700 & $c) << 2);
              } else if ($c < 0x10000) {
                $i= 0x00E08080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4;
                $out.= pack("Cn", ($i & 0xFF0000) >> 16, $i & 0xFFFF);
              } else if ($c < 0x110000) {
                $out.= pack("N", 0xF0808080 | 0x3F & $c | (0xC0 & $c) << 2 | (0x0F00 & $c) << 2 | (0xF000 & $c) << 4 | (0x030000 &$c) << 4 | (0x1C0000 & $c) << 6);
              }
            }
          }
          return $out;
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
          'Failed (expected: "%s", actual: "%s")',
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
