<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'util.cmd.Command',
    'rdbms.DriverManager',
    'io.File',
    'text.CSVGenerator'
  );

  /**
   * Executes SQL and writes data to a file
   * 
   * @see      xp://text.CSVGenerator
   * @purpose  Command
   */
  class SelectIntoOutfile extends Command {
    protected $connection= NULL;
    protected $generator= NULL;
    
    /**
     * Constructor. Initializes CSV generator
     *
     */
    public function __construct() {
      $this->generator= new CSVGenerator();
    }

    /**
     * Set connection DSN
     *
     * @param   string dsn
     */
    #[@arg]
    public function setDsn($dsn) {
      $this->connection= DriverManager::getConnection($dsn);
      $this->connection->connect();
    }

    /**
     * Set SQL statement
     *
     * @param   string statement
     */
    #[@arg]
    public function setStatement($statement) {
      $this->query= cast($this->connection->query($statement), 'rdbms.ResultSet');
      $this->generator->setHeader(array_keys($this->query->fields));
    }

    /**
     * Set filename of file to write output to
     *
     * @param   string filename
     */
    #[@arg]
    public function setOut($file= 'php://stdout') {
      $this->generator->setOutputStream(new File($file));
    }
    
    /**
     * Formats a value as a string
     *
     * @param   * value
     * @return  string
     */
    protected function format($value) {
      if ($value instanceof Date) {
        return $value->toString('Y-m-d H:i:s');
      }
      return $value;
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      while ($record= $this->query->next()) {
        $this->generator->writeRecord(array_map(array($this, 'format'), array_values($record)));
      }
    }
  }
?>
