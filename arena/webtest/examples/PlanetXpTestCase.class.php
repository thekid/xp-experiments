<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.web.WebTestCase'
  );

  /**
   * TestCase
   *
   * @see      xp://unittest.web.WebTestCase
   * @see      http://planet-xp.net/
   * @purpose  Web test case
   */
  class PlanetXpTestCase extends WebTestCase {
  
    /**
     * Set up this test case. Creates connection.
     *
     */
    public function setUp() {
      $this->conn= new HttpConnection('http://planet-xp.net/');
    }
  
    /**
     * Test
     *
     */
    #[@test]
    public function homePage() {
      $this->beginAt('/xml/home');
      $this->assertStatus(HTTP_OK);
      $this->assertTitleEquals('XP Technology');
      $this->assertTextPresent('Credits');
    }
  }
?>
