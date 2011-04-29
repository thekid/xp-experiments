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
  abstract class StaticCallable extends Enum implements Profileable {
    public static
      $callable,
      $method_exists;
    
    static function __static() {
      self::$callable= newinstance(__CLASS__, array(0, 'callable'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            is_callable(array(__CLASS__, "__static"));
          }
        }
      }');
      self::$method_exists= newinstance(__CLASS__, array(1, 'method_exists'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            method_exists(__CLASS__, "__static");
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
