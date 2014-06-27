<?php
use util\cmd\Console;

class WorkerThread extends Thread {

  public function __construct($i) {
    $this->i= $i;
  }

  public function run() {
    define('STDIN', fopen('php://stdin', 'r'));
    define('STDOUT', fopen('php://stdout', 'w'));
    define('STDERR', fopen('php://stderr', 'w'));
    Console::initialize(true);

    // Actual run() implementation
    usleep(1000 * rand(10, 2000));
    Console::writeLinef('Worker #%d ran in thread %lu', $this->i, $this->getThreadId());
  }
}

class Counters extends \lang\Object {
  public static function main($args) {
    Console::writeLine('Started');
    $n= $args ? (int)$args[0] : 10;

    $workers= [];
    foreach (range(1, $n) as $i) {
      $workers[$i]= new WorkerThread($i);
      $workers[$i]->start();
    }

    Console::writeLine(sizeof($workers), ' worker(s) started');
    foreach (range(1, $n) as $i) {
      $workers[$i]->join();
    }    
    Console::writeLine('Done');
  }
}
