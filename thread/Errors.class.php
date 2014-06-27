<?php
use util\cmd\Console;

class ExecutorThread extends Thread {

  public function __construct($fail) {
    $this->fail= $fail;
  }

  public function run() {
    define('STDIN', fopen('php://stdin', 'r'));
    define('STDOUT', fopen('php://stdout', 'w'));
    define('STDERR', fopen('php://stderr', 'w'));
    Console::initialize(true);
    register_shutdown_function(function() {
      $error= error_get_last();
      if (E_ERROR === $error['type'] || E_USER_ERROR === $error['type']) {
        Console::writeLinef(
          '*** Thread %lu exited abnormally: %s in %s on line %d',
          $this->getThreadId(),
          $error['message'],
          $error['file'],
          $error['line']
        );
      }
    });

    // Actual run() implementation
    if ($this->fail) {
      $run= null;
    } else {
      $run= function() {
        Console::writeLine('Ran successfully');
      };
    }
    $run();
  }
}

class Errors extends \lang\Object {
  public static function main($args) {
    Console::writeLine('Started');

    $workers= [];
    foreach (range(true, false) as $i) {
      $workers[$i]= new ExecutorThread($i);
      $workers[$i]->start();
    }

    foreach (range(1, $n) as $i) {
      $workers[$i]->join();
    }    
    Console::writeLine('Done');
  }
}
