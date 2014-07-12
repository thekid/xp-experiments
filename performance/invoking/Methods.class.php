<?php namespace invoking;

/**
 * Methods Profiling
 */
abstract class Methods extends \lang\Enum implements \Profileable {
  public static $direct;
  public static $via_array;
  public static $via_closure;
  
  static function __static() {
    self::$direct= newinstance(__CLASS__, [0, 'direct'], '{
      static function __static() { }

      public function run($times) {
        for ($i= 0; $i < $times; $i++) {
          $this->fixture();
        }
      }
    }');
    self::$via_array= newinstance(__CLASS__, [1, 'via_array'], '{
      static function __static() { }

      public function run($times) {
        $array= [$this, "fixture"];
        for ($i= 0; $i < $times; $i++) {
          $array();
        }
      }
    }');
    self::$via_closure= newinstance(__CLASS__, [2, 'via_closure'], '{
      static function __static() { }

      public function run($times) {
        $closure= (new \ReflectionMethod($this, "fixture"))->getClosure($this);
        for ($i= 0; $i < $times; $i++) {
          $closure();
        }
      }
    }');
  }

  /** @return void */
  public function fixture() {
    /* Intentionally empty */
  }
}
