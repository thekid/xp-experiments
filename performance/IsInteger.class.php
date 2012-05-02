<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.Enum', 'Profileable');

  /**
   * Numeric profilung
   *
   * @purpose  Profiling
   */
  abstract class IsInteger extends Enum implements Profileable {
    public static
      $is_numeric,
      $strspn,
      $regexp,
      $casting;
    
    static function __static() {
      self::$is_numeric= newinstance(__CLASS__, array(0, 'is_numeric'), '{
        static function __static() { }

        public function run($times) {
          $arg= "19.19";
          for ($i= 0; $i < $times; $i++) {
            is_numeric($arg) && (int)$arg == $arg;
          }
        }
      }');
      self::$strspn= newinstance(__CLASS__, array(1, 'strspn'), '{
        static function __static() { }

        public function run($times) {
          $arg= "19.19";
          for ($i= 0; $i < $times; $i++) {
            strspn($arg, "0123456789") === strlen($arg);
          }
        }
      }');
      self::$regexp= newinstance(__CLASS__, array(2, 'regexp'), '{
        static function __static() { }

        public function run($times) {
          $arg= "19.19";
          for ($i= 0; $i < $times; $i++) {
            preg_match("/^\-?[0-9]+$/", $arg);
          }
        }
      }');
      self::$casting= newinstance(__CLASS__, array(3, 'casting'), '{
        static function __static() { }

        public function run($times) {
          $arg= "19.19";
          for ($i= 0; $i < $times; $i++) {
            (string)(int)$arg === (string)$arg;
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
