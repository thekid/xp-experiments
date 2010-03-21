<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'rdbms.DriverManager',
    'util.log.LogObserver',
    'util.log.LogCategory',
    'util.log.ConsoleAppender'
  );

  /**
   * Runs an SQL query
   *
   */
  class SqlQuery extends Command {
    protected $conn= NULL;
    protected $query= NULL;
  
    /**
     * Set database connection
     *
     * @param   string dsn in the form [driver]://[username]:[password]@[host]
     */
    #[@arg(position= 0)]
    public function setConnection($dsn) {
      $this->conn= DriverManager::getConnection($dsn);
      $this->conn->connect();
      $this->out->writeLine('Connected to ', $this->conn);
    }
    
    /**
     * Sets SQL query to run
     *
     * @param   string sql the complete SQL statement
     */
    #[@arg(position= 1)]
    public function setQuery($sql) {
      $this->query= $sql;
    }

    /**
     * Sets whether to be verbose
     *
     */
    #[@arg]
    public function setVerbose() {
      $this->conn->addObserver(new LogObserver(
        create(new LogCategory())->withAppender(new ConsoleAppender())
      ));
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $q= $this->conn->query($this->query);
      if (!$q instanceof ResultSet) {
        $this->out->writeLine('Result: ', $this->query);
      } else {
        $i= 0;
        while ($record= $q->next()) {
          $this->out->writeLine('- ', $record);
          $i++;
        }
        $this->out->writeLine($i, ' row(s) returned');
      }
    }
  }
?>
