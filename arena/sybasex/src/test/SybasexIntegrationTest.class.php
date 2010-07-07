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
      $original= clone $this->dsn->url;

      try {
        $this->dsn->url->setPassword('wrong-password');
        $this->connect();
      } catch (Throwable $t) {
        $this->dsn->url= $original;
        throw $t;
      }
    }

    #[@test]
    public function selectInteger() {
      $r= $this->conn()->query('select 1 as column_integer');
      $this->assertInstanceof('rdbms.sybasex.SybasexResultSet', $r);
      $this->assertEquals(array('column_integer' => 1), $r->next());
    }

    #[@test]
    public function selectIntegerWithField() {
      $r= $this->conn()->query('select 1 as column_integer');
      $this->assertInstanceof('rdbms.sybasex.SybasexResultSet', $r);
      $this->assertEquals(1, $r->next('column_integer'));
    }
  }
?>
