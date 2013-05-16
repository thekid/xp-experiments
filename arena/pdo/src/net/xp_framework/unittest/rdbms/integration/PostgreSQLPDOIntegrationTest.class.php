<?php
/* This class is part of the XP framework
 *
 * $Id: MySQLIntegrationTest.class.php 13384 2009-08-14 14:00:44Z kiesel $ 
 */

  uses('net.xp_framework.unittest.rdbms.integration.PostgreSQLIntegrationTest');

  /**
   * MySQL integration test
   *
   * @ext       mysql
   */
  class PostgreSQLPDOIntegrationTest extends PostgreSQLIntegrationTest {
  
    static function __static() {
      DriverManager::register('pdo+pgsql', XPClass::forName('rdbms.pdo.PDOConnection'));
    }
    
    /**
     * Retrieve dsn
     *
     * @return  string
     */
    public function _dsn() {
      return 'pdo+pgsql';
    }
  }
?>
