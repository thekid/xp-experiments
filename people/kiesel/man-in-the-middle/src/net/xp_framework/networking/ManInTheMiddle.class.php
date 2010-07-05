<?php

  uses(
    'util.cmd.Command',
    'peer.server.ForkingServer',
    'net.xp_framework.networking.ManInTheMiddleProtocol'
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
      $server= new Server('localhost', $this->localport);
      $server->setProtocol(new ManInTheMiddleProtocol($this->server, $this->port, $this->out));

      $this->out->writeLine('---> Listening on port ', $this->localport);

      try {
        $server->init();
        $server->service();
        $server->shutdown();
      } catch (IOException $e) {
        $e->printStackTrace();
      }
    }
  }

?>