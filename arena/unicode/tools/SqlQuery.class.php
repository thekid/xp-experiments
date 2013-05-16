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
      $this->out->writeLine('Using ', $this->conn);
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
        create(new LogCategory('sql'))->withAppender(new ConsoleAppender())
      ));
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $this->conn->connect();
      $q= $this->conn->query($this->query);
      if (!$q instanceof ResultSet) {
        $this->out->writeLine('Result: ', $q);
      } else {
        $i= 0;
        while ($record= $q->next()) {
          $i++;
          $this->out->writeLine('== Record #', $i, ' ==========');
          foreach ($record as $field => $value) {
            $this->out->writef('[%-21s] ', $field);
            if ($value instanceof String) {
              $this->out->writeLine($value, ' (', $value->getBytes('utf-8'), ')');
            } else {
              $this->out->writeLine(xp::stringOf($value));
            }
          }
        }
        $this->out->writeLine('== ', $i, ' row(s) returned ==');
      }
    }
  }
?>
