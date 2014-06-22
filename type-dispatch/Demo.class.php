<?php
use util\cmd\Console;
use lang\Error;

class Demo extends \lang\Object {

  static function __callStatic($name, $args) {
    static $cache= [];

    $call= get_called_class();
    $method= $name.'§';
    $key= $call.$method;
    if (!isset($cache[$key])) {
      if (!method_exists($call, $method)) return parent::__callStatic($name, $args);

      $cache[$key]= [];
      foreach ($call::$method() as $signature => $closure) {
        $cache[$key][]= [Signature::parse($signature), $closure];
      }
    }

    foreach ($cache[$key] as $def) {
      if ($def[0]->matches($args)) return call_user_func_array($def[1], $args);
    }
    throw new Error('No applicable match for '.$call.'::'.$name.'()');
  }

  protected static function map§() {
    return [
      'var[], function(string): string' => function($args, $func) {
        return array_map($func, $args);
      }
    ];
  }

  protected static function directMap($args, $func) {
    return array_map($func, $args);
  }

  public static function main($args) {
    $times= 100000;
    $f= function($arg) { return '@'.$arg; };

    $t= \util\profiling\Timer::measure(function() use($times, $f, $args) {
      for ($i= 0; $i < $times; $i++) {
        self::map($args, $f);
      }
      Console::writeLine(self::map($args, $f));
    });
    Console::writeLinef('Dispatch: %d invocations, %.3f seconds taken: %s', $times, $t->elapsedTime(), \xp::stringOf(\xp::$errors));

    \xp::gc();
    $t= \util\profiling\Timer::measure(function() use($times, $f, $args) {
      for ($i= 0; $i < $times; $i++) {
        self::directMap($args, $f);
      }
      Console::writeLine(self::directMap($args, $f));
    });
    Console::writeLinef('Direct: %d invocations, %.3f seconds taken: %s', $times, $t->elapsedTime(), \xp::stringOf(\xp::$errors));
  }
}