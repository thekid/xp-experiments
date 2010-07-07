<?php
  uses(
    'unittest.TestCase',
    'rdbms.sybasex.SybasexConnection'
  );
  
  class SybasexIntegrationTest extends TestCase {
    protected
      $dsn      = NULL,
      $fixture  = NULL;
      
    public function __construct($name, $args) {
      parent::__construct($name);
      
      $this->dsn= new DSN($args);
    }
    
    public function setUp() {
    
    }
    
    public function tearDown() {
      if ($this->fixture instanceof DBConnection) $this->fixture->close();
    }
    
    public function conn() {
      return $this->fixture= new SybasexConnection($this->dsn);
    }
    
    #[@test]
    public function connect() {
      $this->assertTrue(create($this->conn())->connect(FALSE));
    }
    
    #[@test, @expect('rdbms.SQLConnectException')]
    public function connectFail() {
      $this->dsn->url->setPassword('wrong-password');
      $this->connect();
    }
  }
?>