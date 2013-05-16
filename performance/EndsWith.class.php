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
  abstract class EndsWith extends Enum implements Profileable {
    public static
      $substr,
      $strrpos,
      $substr_compare,
      $substr_count;
    
    static function __static() {
      self::$substr= newinstance(__CLASS__, array(0, 'substr'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            substr("/path/to/archive.xar", -4) === ".xar";
          }
        }
      }');
      self::$strrpos= newinstance(__CLASS__, array(1, 'strrpos'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            strrpos($arg, ".xar") === strlen($arg) - 4;
          }
        }
      }');
      self::$substr_compare= newinstance(__CLASS__, array(2, 'substr_compare'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            substr_compare($arg, ".xar", -4) === 0;
          }
        }
      }');
      self::$substr_count= newinstance(__CLASS__, array(3, 'substr_count'), '{
        static function __static() { }

        public function run($times) {
          $arg= "/path/to/archive.xar";
          for ($i= 0; $i < $times; $i++) {
            substr_count($arg, ".xar", strlen($arg) - 4) === 1;
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
