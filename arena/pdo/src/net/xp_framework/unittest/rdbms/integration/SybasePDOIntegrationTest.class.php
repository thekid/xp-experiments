<?php
/* This class is part of the XP framework
 *
 * $Id: MySQLIntegrationTest.class.php 13384 2009-08-14 14:00:44Z kiesel $ 
 */

  uses('net.xp_framework.unittest.rdbms.integration.SybaseIntegrationTest');

  /**
   * MySQL integration test
   *
   * @ext       mysql
   */
  class SybasePDOIntegrationTest extends SybaseIntegrationTest {
  
    static function __static() {
      DriverManager::register('pdo+dblib', XPClass::forName('rdbms.pdo.PDOConnection'));
    }
    
    /**
     * Retrieve dsn
     *
     * @return  string
     */
    public function _dsn() {s
      return 'pdo+sybase';
    }
  }
?>
