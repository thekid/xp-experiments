<?php
require('newinstance_.php');

class Test extends \lang\Object {

  public static function main($args) {
    $run= newinstance_('lang.Runnable', [], [
      'run' => function($self) {
        Console::writeLine('It works - inside ', $self->getClassName());
      }
    ]);

    $run->run();
  }
}