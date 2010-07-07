<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'peer.Socket',
    'util.log.Traceable',
    'rdbms.DBConnection',
    'rdbms.Transaction',
    'rdbms.StatementFormatter',
    'rdbms.sybase.SybaseDialect',
    'rdbms.sybasex.SybasexProtocol'
  );

  /**
   * Connection to Sybase databases using client libraries
   *
   * @see      http://sybase.com/
   * @ext      sybase_ct
   * @test     xp://net.xp_framework.unittest.rdbms.TokenizerTest
   * @test     xp://net.xp_framework.unittest.rdbms.DBTest
   * @purpose  Database connection
   */
  class SybasexConnection extends DBConnection implements Traceable {
    protected
      $protocol = NULL;
    
    protected
      $cat      = NULL;

    /**
     * Constructor
     *
     * @param   rdbms.DSN dsn
     */
    public function __construct($dsn) {
      parent::__construct($dsn);
      $this->formatter= new StatementFormatter($this, new SybaseDialect());
    }

    /**
     * Set Timeout
     *
     * @param   int timeout
     */
    public function setTimeout($timeout) {
      parent::setTimeout($timeout);
    }
    
    public function setTrace($cat) {
      $this->cat= $cat;
    }

    /**
     * Connect
     *
     * @param   bool reconnect default FALSE
     * @return  bool success
     * @throws  rdbms.SQLConnectException
     */
    public function connect($reconnect= FALSE) {
      $this->protocol= new SybasexProtocol();
      $this->protocol->setTrace($this->cat);
      
      $result= $this->protocol->connect(
        $this->dsn->getHost(),
        $this->dsn->getUser(),
        $this->dsn->getPassword()
      );

      if (!$result) {
        throw new SQLConnectException(trim("TODO: FIND LAST MESSAGE"), $this->dsn);
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
      if ($this->protocol instanceof SybasexProtocol) {
        $this->protocol->disconnect();
        $this->protocol= NULL;
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
      // TBI
      return TRUE;
    }
    
    /**
     * Retrieve identity
     *
     * @return  var identity value
     */
    public function identity($field= NULL) {
      $i= $this->query('select @@identity as i')->next('i');
      $this->_obs && $this->notifyObservers(new DBEvent(__FUNCTION__, $i));
      return $i;
    }

    /**
     * Retrieve number of affected rows for last query
     *
     * @return  int
     */
    protected function affectedRows() {
      // TBI
      return 0;
    }
    
    /**
     * Execute any statement
     *
     * @param   string sql
     * @param   bool buffered default TRUE
     * @return  rdbms.sybase.SybaseResultSet or TRUE if no resultset was created
     * @throws  rdbms.SQLException
     */
    protected function query0($sql, $buffered= TRUE) {
      if (NULL === $this->protocol) {
        if (!($this->flags & DB_AUTOCONNECT)) throw new SQLStateException('Not connected');
        $c= $this->connect();

        // Check for subsequent connection errors
        if (FALSE === $c) throw new SQLStateException('Previously failed to connect');
      }

      $this->protocol->sendQuery($sql);
      return $this->protocol->resultSet();
    }
    
    /**
     * Begin a transaction
     *
     * @param   rdbms.Transaction transaction
     * @return  rdbms.Transaction
     */
    public function begin($transaction) {
      $this->query('begin transaction xp_%c', $transaction->name);
      $transaction->db= $this;
      return $transaction;
    }
    
    /**
     * Retrieve transaction state
     *
     * @param   string name
     * @return  var state
     */
    public function transtate($name) { 
      return $this->query('select @@transtate as transtate')->next('transtate');
    }
    
    /**
     * Rollback a transaction
     *
     * @param   string name
     * @return  bool success
     */
    public function rollback($name) { 
      return $this->query('rollback transaction xp_%c', $name);
    }
    
    /**
     * Commit a transaction
     *
     * @param   string name
     * @return  bool success
     */
    public function commit($name) { 
      return $this->query('commit transaction xp_%c', $name);
    }
  }
?>
