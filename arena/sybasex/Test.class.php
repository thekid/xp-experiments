<?php

  uses(
    'util.cmd.Command',
    'util.log.Logger',
    'util.log.ColoredConsoleAppender',
    'peer.Socket',
    'rdbms.sybasex.SybasexConnection'
  );

  class Test extends Command {
    protected
      $host = NULL,
      $user = NULL,
      $pass = NULL;

    /**
     * Set host to connect to
     *
     * @param   string host
     */
    #[@arg]
    public function setHost($host) {
      $this->host= $host;
    }

    /**
     * Set username
     *
     * @param   string user
     */
    #[@arg]
    public function setUser($user) {
      $this->user= $user;
    }

    /**
     * Set password
     *
     * @param   string pass
     */
    #[@arg]
    public function setPass($pass) {
      $this->pass= $pass;
    }

    public function run() {
      $conn= new SybasexConnection(new DSN('sybase://'.$this->user.':'.$this->pass.'@'.$this->host.'/'));
      $conn->setTrace(Logger::getInstance()->getCategory()->withAppender(new ColoredConsoleAppender()));
      $conn->connect();
    }
  }

?>