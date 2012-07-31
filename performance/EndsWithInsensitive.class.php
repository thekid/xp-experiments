<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum', 'Profileable');

  /**
   * Tests whether a string ends with a given other string
   *
   * @purpose  Profiling
   */
  abstract class EndsWithInsensitive extends Enum implements Profileable {
    public static
      $substr_strtolower,
      $substr_strncmp,
      $strripos,
      $substr_compare;
    
    static function __static() {
      self::$substr_strtolower= newinstance(__CLASS__, array(0, 'substr_strtolower'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            (strtolower(substr("/path/to/archive.xar", -4)) === ".xar");
          }
        }
      }');
      self::$substr_strncmp= newinstance(__CLASS__, array(1, 'substr_strncmp'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            (strncmp(substr("/path/to/archive.xar", -4), ".xar", 4) === 0);
          }
        }
      }');
      self::$strripos= newinstance(__CLASS__, array(2, 'strripos'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            (strripos($arg, ".xar") === strlen($arg) - 4);
          }
        }
      }');
      self::$substr_compare= newinstance(__CLASS__, array(3, 'substr_compare'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            (substr_compare($arg, ".xar", -4, 4, TRUE) === 0);
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
