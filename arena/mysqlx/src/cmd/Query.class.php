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
    protected $queries= array();
    
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
     * Set SQL queries to execute
     *
     * @param   string[] query
     */
    #[@args(select= '[1..]')]
    public function setQuery($queries) {
      $this->queries= $queries;
    }
    
    /**
     * Main runner method
     *
     */
    public function run() {
      foreach ($this->queries as $query) {
        $this->out->writeLine('Q: ', $query);
        try {
          $q= $this->protocol->query($query);
          if (is_array($q)) {
            $i= 0;
            while ($r= $this->protocol->fetch($q)) {
              $this->out->writeLine(++$i, ': ', $r);
            }
          } else {
            $this->out->writeLine($q);
          }
        } catch (Throwable $e) {
          $this->err->writeLine($e);
        }
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
