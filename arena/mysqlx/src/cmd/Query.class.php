<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'rdbms.DriverManager',
    'rdbms.mysqlx.MySqlxConnection',
    'util.profiling.Timer'
  );

  /**
   * Performs an SQL query
   *
   */
  class Query extends Command {
    protected $connection= NULL;
    protected $queries= array();
    
    static function __static() {
      DriverManager::register('mysqlx', XPClass::forName('rdbms.mysqlx.MySqlxConnection'));
    }
    
    /**
     * Set dsn (e.g. mysqlx://user:pass@host[:port])
     *
     * @param   string dsn
     */
    #[@arg(position= 0)]
    public function setConnection($dsn) {
      $this->connection= DriverManager::getConnection($dsn);
      $this->connection->connect();
      $this->out->writeLine('C: ', $this->connection);
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
      $t= new Timer();
      foreach ($this->queries as $query) {
        $this->out->writeLine('Q: ', $query);
        $t->start();
        try {
          $q= $this->connection->query($query);
          if ($q instanceof ResultSet) {
            $i= 0;
            while ($r= $q->next()) {
              $this->out->writeLine(++$i, ': ', $r);
            }
          } else {
            $this->out->writeLine(typeof($q), ': ', $q);
          }
        } catch (Throwable $e) {
          $this->err->writeLine($e);
        }
        $t->stop();
        $this->out->writeLinef('%.3f seconds', $t->elapsedTime());
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
