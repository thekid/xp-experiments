<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'rdbms.mysqlx.MySqlxConnection',
    'peer.Socket',
    'rdbms.DSN'
  );

  /**
   * Performs an SQL query
   *
   */
  class Query extends Command {
    protected $connection= NULL;
    protected $queries= array();
    
    /**
     * Set dsn (e.g. mysqlx://user:pass@host[:port])
     *
     * @param   string dsn
     */
    #[@arg(position= 0)]
    public function setConnection($dsn) {
      $this->connection= new MySqlxConnection(new DSN($dsn));
      $this->connection->connect();
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
          $q= $this->connection->query($query);
          if ($q instanceof ResultSet) {
            $i= 0;
            while ($r= $q->next()) {
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
      $this->connection && $this->connection->close();
    }
  }
?>
