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
      $this->protocol= new MySqlxProtocol(new Socket($dsn->getHost(), $dsn->getPort(3306)));
      $this->protocol->connect($dsn->getUser(), $dsn->getPassword());
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
        $q= $this->protocol->query($this->query);
        $i= 0;
        while ($r= $this->protocol->fetch($q)) {
          $this->out->writeLine(++$i, ': ', $r);
        }
      } catch (Throwable $e) {
        $this->err->writeLine($e);
      }
    }

    /**
     * Destructor. Closes communications.
     *
     */
    public function __destruct() {
      $this->protocol && $this->protocol->close();
    }
  }
?>
