<?php

  uses(
    'util.cmd.Command',
    'util.log.Logger',
    'util.log.ColoredConsoleAppender',
    'rdbms.sybasex.SybasexConnection'
  );

  /**
   * Run a collection of various queries to verify
   * the progress of the implemented driver
   *
   */
  class RunCollectionOfQueries extends Command {
    protected
      $dsn  = NULL;

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
     * Run
     *
     */
    public function run() {
      $conn= new SybasexConnection($this->dsn);
      $conn->setTrace(Logger::getInstance()->getCategory()->withAppender(new ColoredConsoleAppender()));

      $conn->connect();
      $conn->query('
        select 1 as type_int4,
        convert(numeric(10,6), 1) as type_numeric,
        "foo" as varchar_type,
        convert(smallint, NULL) as type_smallint
      ');
    }
  }

?>