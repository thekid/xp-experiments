<?php namespace invoking;

/**
 * Functions Profiling
 */
abstract class Functions extends \lang\Enum implements \Profileable {
  public static $closure_direct;
  public static $direct;
  public static $via_string;
  public static $via_closure;
  
  static function __static() {
    self::defineFixture();

    self::$closure_direct= newinstance(__CLASS__, [0, 'closure_direct'], '{
      static function __static() { }

      public function run($times) {
        $closure= function() { };
        for ($i= 0; $i < $times; $i++) {
          $closure();
        }
      }
    }');
    self::$direct= newinstance(__CLASS__, [1, 'direct'], '{
      static function __static() { }

      public function run($times) {
        for ($i= 0; $i < $times; $i++) {
          fixture();
        }
      }
    }');
    self::$via_string= newinstance(__CLASS__, [2, 'via_string'], '{
      static function __static() { }

      public function run($times) {
        $string= "fixture";
        for ($i= 0; $i < $times; $i++) {
          $string();
        }
      }
    }');
    self::$via_closure= newinstance(__CLASS__, [3, 'via_closure'], '{
      static function __static() { }

      public function run($times) {
        $closure= (new \ReflectionFunction("fixture"))->getClosure();
        for ($i= 0; $i < $times; $i++) {
          $closure();
        }
      }
    }');
  }

  /**
   * Defines fixture function in global namespace.
   *
   * @return  void
   */
  public static function defineFixture() {
    eval('function fixture() { /* Intentionally empty */ }');
  }
}
