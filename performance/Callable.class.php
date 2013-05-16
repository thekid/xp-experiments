<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.Enum', 'Profileable');

  /**
   * Increment profiling
   *
   * @purpose  Profiling
   */
  abstract class Callable extends Enum implements Profileable {
    public static
      $this_is_callable,
      $this_method_exists,
      $static_method_exists;
    
    static function __static() {
      self::$this_is_callable= newinstance(__CLASS__, array(0, 'this_is_callable'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            is_callable(array($this, "run"));
          }
        }
      }');
      self::$this_method_exists= newinstance(__CLASS__, array(2, 'this_method_exists'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            method_exists($this, "run");
          }
        }
      }');
      self::$static_method_exists= newinstance(__CLASS__, array(3, 'static_method_exists'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            method_exists(__CLASS__, "run");
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
