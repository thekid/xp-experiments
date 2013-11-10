<?php
function newinstance_($intf, $args, $def) {
  static $uniq= 0;

  $uniq++;
  $src= 'class NewInstance_'.$uniq.' implements '.\lang\XPClass::forName($intf)->literal().' { static $def; ';
  foreach ($def as $name => $function) {

    // Create pass
    $r= new ReflectionFunction($function);
    $pass= '';
    foreach ($r->getParameters() as $param) {
      $pass.= ', '.$param->getName();
    }

    // Create method
    $src.= 'function '.$name.'('.substr($pass, 2).') {
      return call_user_func(self::$def["'.$name.'"]'.('' === $pass ? '' : ', '.substr($pass, 2)).');
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