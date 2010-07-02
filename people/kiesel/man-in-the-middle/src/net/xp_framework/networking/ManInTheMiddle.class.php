<?php

  uses(
    'util.cmd.Command',
    'peer.Socket',
    'peer.ServerSocket'
  );

  class ManInTheMiddle extends Command {
    protected
      $server     = NULL,
      $port       = NULL,
      $localport  = NULL;

    #[@arg(position= 0)]
    public function setServer($s) {
      $this->server= $s;
    }

    #[@arg(position= 1)]
    public function setPort($p) {
      $this->port= $p;
    }

    #[@arg]
    public function setLocalPort($p= 8080) {
      $this->localport= $p;
    }

    public function run() {
      $socket= new ServerSocket('localhost', $this->localport);

      $socket->create();
      $socket->bind();
      $socket->listen();

      $this->out->writeLine('---> Listening on port ', $this->localport);

      while ($client= $socket->accept()) {
        $this->out->writeLine('---> New incoming connection');

        $this->serve($client);
      }
    }

    protected function serve(Socket $left) {
      $right= new BSDSocket($this->server, $this->port);
      $right->connect();

      // Set both sockets to non-blocking
      $right->setBlocking(FALSE);
      $left->setBlocking(FALSE);

      while ($left->isConnected() && $right->isConnected()) {
        $this->out->write('.');

        if (strlen($data= $left->readBinary()) > 0) {
          $this->out->writeLine('>>> '.addcslashes($data, "\0..\37!@\177..\377"));
          $right->write($data);
        }

        if (strlen($data= $right->readBinary()) > 0) {
          $this->out->writeLine('<<< '.addcslashes($data, "\0..\37!@\177..\377"));
          $left->write($data);
        }

        usleep(100000);
      }

      if (!$left->isConnected()) {
        $this->out->writeLine('---> Server socket has closed connection.');
      }

      if (!$right->isConnected()) {
        $this->out->writeLine('---> Client socket has closed connection.');
      }

      $left->close();
      $right->close();
    }
  }

?>