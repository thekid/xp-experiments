<?php
function newinstance_($intf, $args, $def) {
  static $uniq= 0;

  $uniq++;
  $src= 'class NewInstance_'.$uniq.' implements '.\lang\XPClass::forName($intf)->literal().' { static $def; ';
  foreach ($def as $name => $function) {
    $src.= 'function '.$name.'() {
      return call_user_func(self::$def["'.$name.'"], func_get_args());
    }';
  }
  $src.= '}';
  eval($src);
  $c= new ReflectionClass('NewInstance_'.$uniq);
  $c->setStaticPropertyValue('def', $def);
  return $c->newInstanceArgs($args);
}

class Test extends \lang\Object {

  public static function main($args) {
    $run= newinstance_('lang.Runnable', [], [
      'run' => function() {
        //Console::writeLine('Running...');
      }
    ]);

    Console::writeLine('Running...');
    $times= 1000000;
    $timer= \util\profiling\Timer::measure(function() use($run, $times) {
      for ($i= 0; $i < $times; $i++) {
        $run->run();
      }
    });
    Console::writeLinef('%.3f seconds for %d run(s)', $timer->elapsedTime(), $times);
  }
}