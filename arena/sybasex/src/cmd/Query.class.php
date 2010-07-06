<?php

  uses(
    'util.cmd.Command',
    'util.log.Logger',
    'util.log.ColoredConsoleAppender',
    'rdbms.sybasex.SybasexConnection'
  );

  /**
   * Run a query given on command line on the specified connection
   *
   */
  class Query extends Command {
    protected
      $dsn  = NULL,
      $q    = NULL;

    /**
     * Set DSN
     *
     * @param   string host
     */
    #[@arg(position= 0)]
    public function setDSN($dsn) {
      $this->dsn= new DSN($dsn);
    }
    
    /**
     * Set query to execute
     *
     * @param   string
     */
    #[@arg(position= 1)]
    public function setQuery($q) {
      $this->q= $q;
    }

    /**
     * Run
     *
     */
     public function run() {
      $conn= new SybasexConnection($this->dsn);
      $conn->setTrace(Logger::getInstance()->getCategory()->withAppender(new ColoredConsoleAppender()));

      $conn->connect();
      $conn->query($this->q);
    }
  }

?>