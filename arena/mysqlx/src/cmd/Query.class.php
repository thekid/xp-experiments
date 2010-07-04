<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'rdbms.mysqlx.MySqlxProtocol',
    'peer.Socket',
    'rdbms.DSN'
  );

  /**
   * Performs an SQL query
   *
   */
  class Query extends Command {
    protected $protocol= NULL;
    protected $query= NULL;
    
    /**
     * Set dsn (e.g. mysqlx://user:pass@host[:port])
     *
     * @param   string dsn
     */
    #[@arg(position= 0)]
    public function setConnection($dsn) {
      $dsn= new DSN($dsn);
      $this->protocol= new MySqlxProtocol();
      $s= new Socket($dsn->getHost(), $dsn->getPort(3306));
      $this->protocol->connect($s, $dsn->getUser(), $dsn->getPassword());
    }

    /**
     * Set SQL query to execute
     *
     * @param   string query
     */
    #[@arg(position= 1)]
    public function setQuery($query) {
      $this->query= $query;
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      try {
        $this->out->writeLine($this->protocol->query($this->query));
      } catch (Throwable $e) {
        $this->err->writeLine($e);
      }
    }
  }
?>
