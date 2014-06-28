<?php
use util\cmd\Console;

class TaskThread extends Thread {

  public function __construct($closure) {
    $this->closure= $closure;
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
    if (is_string($this->closure)) {
      $f= eval('return '.$this->closure.';');
    } else {
      $f= $this->closure;
    }
    $f();
  }
}

class Task extends \lang\Object {
  public static $closures= [];

  public static function startNew($closure) {
    $t= new TaskThread($closure);
    $t->start();
    return $t;
  }
}

class Tasks extends \lang\Object {
  public static function main($args) {
    Console::writeLine('Started');

    $t1= Task::startNew('function() { \util\cmd\Console::writeLine("Task ran"); }');
    $t1->join();

    $t2= Task::startNew(function() { Console::writeLine('Closure ran'); });
    $t2->join();

    Console::writeLine('Done');
  }
}
