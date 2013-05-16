<?php
  #requires \de\thekid\log4x @ 1.0;

  use \de\thekid\log4x\Logger;
  
  class Log {
  
    public static function main(array $args) {
      $log= Logger::getInstance();
      $log->info('Starting up');
      $log->warn('Cannot find a configuration file');
      $log->error('Cannot continue, bailing');
    }
  }
?>
