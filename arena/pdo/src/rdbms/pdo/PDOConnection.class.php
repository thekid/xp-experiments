<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'rdbms.DBConnection',
    'rdbms.pdo.PDOResultSet',
    'rdbms.Transaction',
    'rdbms.StatementFormatter'
  );

  /**
   * Connection to MySQL Databases
   *
   * @see      http://mysql.org/
   * @ext      pdo
   * @test     xp://net.xp_framework.unittest.rdbms.TokenizerTest
   * @test     xp://net.xp_framework.unittest.rdbms.DBTest
   * @purpose  Database connection
   */
  class PDOConnection extends DBConnection {
    private
      $formatter= NULL;

    /**
     * Set Timeout
     *
     * @param   int timeout
     */
    public function setTimeout($timeout) {
      // TODO
      parent::setTimeout($timeout);
    }


    /**
     * Constructor
     *
     * @param   rdbms.DSN dsn
     */
    public function __construct($dsn) { 
      parent::__construct($dsn);
      $this->formatter= new StatementFormatter($this, new MysqlDialect());
    }

    /**
     * Connect
     *
     * @param   bool reconnect default FALSE
     * @return  bool success
     * @throws  rdbms.SQLConnectException
     */
    public function connect($reconnect= FALSE) {
      if (NULL !== $this->handle) return TRUE;  // Already connected
      if (!$reconnect && (FALSE === $this->handle)) return FALSE;    // Previously failed connecting

      $str= sprintf(
        '%s:host=%s;port=%s;dbname=%s',
        substr($this->dsn->getDriver(), 4),
        $this->dsn->getHost(),
        $this->dsn->getPort(3306),
        $this->dsn->getDatabase()
      );
      try {
        $this->handle= new PDO($str, $this->dsn->getUser(), $this->dsn->getPassword());
      } catch (PDOException $e) {
        $this->_obs && $this->notifyObservers(new DBEvent(__FUNCTION__, $reconnect));
        $this->handle= FALSE;
        throw new SQLConnectException($str.': '.$e->getMessage(), $this->dsn);
      }

      $this->_obs && $this->notifyObservers(new DBEvent(__FUNCTION__, $reconnect));
      return parent::connect();
    }
    
    /**
     * Disconnect
     *
     * @return  bool success
     */
    public function close() { 
      if ($this->handle) {
        $this->handle= NULL;
        return TRUE;
      }
      return FALSE;
    }
    
    /**
     * Select database
     *
     * @param   string db name of database to select
     * @return  bool success
     * @throws  rdbms.SQLStatementFailedException
     */
    public function selectdb($db) {
      try {
        $this->handle->exec('use '.$db);
      } catch (PDOException $e) {
        throw new SQLStatementFailedException($e->getMessage(), 'use '.$db, $e->getCode());
      }
      return TRUE;
    }

    /**
     * Prepare an SQL statement
     *
     * @param   string fmt
     * @param   mixed* args
     * @return  string
     */
    public function prepare() {
      $args= func_get_args();
      return $this->formatter->format(array_shift($args), $args);
    }
    
    /**
     * Retrieve identity
     *
     * @return  mixed identity value
     */
    public function identity($field= NULL) {
      $i= $this->handle->lastInsertId($field);
      $this->_obs && $this->notifyObservers(new DBEvent(__FUNCTION__, $i));
      return $i;
    }

    /**
     * Execute an insert statement
     *
     * @param   mixed* args
     * @return  int number of affected rows
     * @throws  rdbms.SQLStatementFailedException
     */
    public function insert() { 
      $args= func_get_args();
      $args[0]= 'insert '.$args[0];
      if (!($r= call_user_func_array(array($this, 'query'), $args))) {
        return FALSE;
      }
      
      return $this->rc;
    }
    
    
    /**
     * Execute an update statement
     *
     * @param   mixed* args
     * @return  int number of affected rows
     * @throws  rdbms.SQLStatementFailedException
     */
    public function update() {
      $args= func_get_args();
      $args[0]= 'update '.$args[0];
      if (!($r= call_user_func_array(array($this, 'query'), $args))) {
        return FALSE;
      }
      
      return $this->rc;
    }
    
    /**
     * Execute an update statement
     *
     * @param   mixed* args
     * @return  int number of affected rows
     * @throws  rdbms.SQLStatementFailedException
     */
    public function delete() { 
      $args= func_get_args();
      $args[0]= 'delete '.$args[0];
      if (!($r= call_user_func_array(array($this, 'query'), $args))) {
        return FALSE;
      }
      
      return $this->rc;
    }
    
    /**
     * Execute a select statement and return all rows as an array
     *
     * @param   mixed* args
     * @return  array rowsets
     * @throws  rdbms.SQLStatementFailedException
     */
    public function select() { 
      $args= func_get_args();
      $args[0]= 'select '.$args[0];
      if (!($r= call_user_func_array(array($this, 'query'), $args))) {
        return FALSE;
      }
      
      $rows= array();
      while ($row= $r->next()) $rows[]= $row;
      return $rows;
    }
    
    /**
     * Execute any statement
     *
     * @param   mixed* args
     * @return  rdbms.mysql.MySQLResultSet or FALSE to indicate failure
     * @throws  rdbms.SQLException
     */
    public function query() { 
      $args= func_get_args();
      $sql= call_user_func_array(array($this, 'prepare'), $args);

      if (!is_object($this->handle)) {
        if (!($this->flags & DB_AUTOCONNECT)) throw new SQLStateException('Not connected');
        $c= $this->connect();
        
        // Check for subsequent connection errors
        if (FALSE === $c) throw new SQLStateException('Previously failed to connect.');
      }
      
      $this->_obs && $this->notifyObservers(new DBEvent(__FUNCTION__, $sql));

      try {
        $result= $this->handle->query($sql);
      } catch (PDOException $e) {
        $code= $e->getCode();
        $message= 'Statement failed: '.$e->getMessage().' @ '.$this->dsn->getHost();
        switch ($code) {
          case 2006: // MySQL server has gone away
          case 2013: // Lost connection to MySQL server during query
            throw new SQLConnectionClosedException('Statement failed: '.$message, $sql, $code);

          case 1213: // Deadlock
            throw new SQLDeadlockException($message, $sql, $code);
          
          default:   // Other error
            throw new SQLStatementFailedException($message, $sql, $code);
        }
      }
      
      if (!is_object($result)) {
        throw new SQLStatementFailedException('Unknown error', $sql, $result);
      } else if (0 === $result->columnCount()) {
        $this->_obs && $this->notifyObservers(new DBEvent('queryend', TRUE));
        $this->rc= $result->rowCount();
        return TRUE;
      }

      $resultset= new PDOResultSet($result, $this->tz);
      $this->_obs && $this->notifyObservers(new DBEvent('queryend', $resultset));

      return $resultset;
    }

    /**
     * Begin a transaction
     *
     * @param   rdbms.Transaction transaction
     * @return  rdbms.Transaction
     */
    public function begin($transaction) {
      if (!$this->query('begin')) return FALSE;
      $transaction->db= $this;
      return $transaction;
    }
    
    /**
     * Rollback a transaction
     *
     * @param   string name
     * @return  bool success
     */
    public function rollback($name) { 
      return $this->query('rollback');
    }
    
    /**
     * Commit a transaction
     *
     * @param   string name
     * @return  bool success
     */
    public function commit($name) { 
      return $this->query('commit');
    }
    
    /**
     * get SQL formatter
     *
     * @return  rdbms.StatementFormatter
     */
    public function getFormatter() {
      return $this->formatter;
    }
  }
?>
