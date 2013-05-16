<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'util.Naming'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class NamingTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function bind() {
      $n= new Naming();
      $n->bind('env/remote/service/dsn', 'xp://user:password@userservice1.schlund.de/');

      $state= $n->create(XPClass::forName('tests.scriptlet.state.ChangePasswordState'));
    }
  }
?>
