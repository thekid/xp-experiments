<?php 
require('newinstance_.php');

class Profile extends \lang\Object {

  public static function main($args) {
    $run= newinstance_('lang.Runnable', [], [
      'run' => function() {
        // Intentionally empty
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