<?php

  uses(
    'util.cmd.Command',
    'util.log.Logger',
    'util.log.ColoredConsoleAppender',
    'peer.Socket',
    'rdbms.sybasex.SybasexProtocol'
  );

  class Test extends Command {
    public function run() {
      $protocol= new SybasexProtocol();
      $protocol->setTrace(Logger::getInstance()->getCategory()->withAppender(new ColoredConsoleAppender()));

      $socket= new Socket('localhost', 1999);
      $socket->setTimeout(2);

      $protocol->connect($socket);
    }
  }

?>