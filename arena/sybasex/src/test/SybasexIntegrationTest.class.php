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
      $this->assertEquals(1, $r->next('column_integer'));
    }

    #[@test]
    public function selectVarchar() {
      $this->assertEquals(
        "foo",
        $this->conn()->query('select "foo" as column_varchar')->next('column_varchar')
      );
    }

    #[@test]
    public function selectNumeric() {
      $this->assertEquals(
        '2000.000000',
        $this->conn()->query('select convert(numeric(10, 6), 2000) as column_numeric')->next('column_numeric')
      );
    }
  }
?>
