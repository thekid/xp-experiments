<?php
use impl\Events;
use util\cmd\Console;

class Timers extends \lang\Object {

  public static function main($args) {
    $events= Events::factory();
    Console::writeLine('Using ', $events);

    $events->setTimeout(function($events, $event) {
      Console::writeLine('Invoked #1 after 500 ms');
      $events->setTimeout(function($events, $event) {
        Console::writeLine('Invoked #1a after 500 + 1000 ms');
      }, 1000);
    }, 500);

    $events->setTimeout(function($events, $event) {
      Console::writeLine('Invoked #2 after 1000ms');
      $events->setTimeout(function($events, $event) {
        Console::writeLine('Invoked #2a after 1000 + 100 ms');
      }, 100);
    }, 1000);

    Console::writeLine('Loop executed ', $events->loop());
  }
}