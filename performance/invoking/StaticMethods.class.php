<?php namespace invoking;

/**
 * Static methods Profiling
 */
abstract class StaticMethods extends \lang\Enum implements \Profileable {
  public static $direct;
  public static $via_array;
  public static $via_closure;
  
  static function __static() {
    self::$direct= newinstance(__CLASS__, [0, 'direct'], '{
      static function __static() { }

      public function run($times) {
        for ($i= 0; $i < $times; $i++) {
          \\invoking\\StaticMethods::fixture();
        }
      }
    }');
    self::$via_array= newinstance(__CLASS__, [1, 'via_array'], '{
      static function __static() { }

      public function run($times) {
        $array= ["invoking\\StaticMethods", "fixture"];
        for ($i= 0; $i < $times; $i++) {
          $array();
        }
      }
    }');
    self::$via_closure= newinstance(__CLASS__, [2, 'via_closure'], '{
      static function __static() { }

      public function run($times) {
        $closure= (new \ReflectionMethod("invoking\\StaticMethods", "fixture"))->getClosure();
        for ($i= 0; $i < $times; $i++) {
          $closure();
        }
      }
    }');
  }

  /** @return void */
  public static function fixture() {
    /* Intentionally empty */
  }
}
