<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.Enum', 'Profileable');

  /**
   * String parsing functions comparison
   *
   * @purpose  Profiling
   */
  abstract class ParseString extends Enum implements Profileable {
    public static
      $sscanf,
      $preg_match;
    
    static function __static() {
      self::$sscanf= newinstance(__CLASS__, array(0, 'sscanf'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            sscanf("GET / HTTP/1.1", "%[A-Z] %s HTTP/1.%d", $verb, $path, $minor);
          }
        }
      }');
      self::$preg_match= newinstance(__CLASS__, array(1, 'preg_match'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            preg_match("#([A-Z]+) ([^ ]+) HTTP/1.([0-9])#", "GET / HTTP/1.1", $matches);
          }
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
  }
?>
