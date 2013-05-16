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
     * Get connection
     *
     * @param   string url
     * @return  peer.http.HttpConnection
     */
    protected function getConnection($url= NULL) {
      return new HttpConnection($url ? $url : 'http://planet-xp.net/');
    }
  
    /**
     * Test
     *
     */
    #[@test]
    public function utf8Html() {
      $this->beginAt('/xml/home');
      $this->assertStatus(HTTP_OK);
      $this->assertContentType('text/html; charset=utf-8');
    }
  
    /**
     * Test
     *
     */
    #[@test]
    public function homePage() {
      $this->beginAt('/xml/home');
      $this->assertTitleEquals('XP Technology');
      $this->assertTextPresent('Credits');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function linksToSelf() {
      $this->beginAt('/xml/home');
      $this->assertLinkPresent('http://planet-xp.net/');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function downloadButton() {
      $this->beginAt('/xml/home');
      $this->assertImagePresent('/common/image/download.png');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function searchForm() {
      $this->beginAt('/xml/home');
      $this->assertFormPresent();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function footer() {
      $this->beginAt('/xml/home');
      $this->assertElementPresent('sites', 'Sites navigation');
      $this->assertElementPresent('main', 'Content area');
      $this->assertElementPresent('menu', 'Top menu');
      $this->assertElementPresent('footer', 'Footer');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function feedbackLinkGoesToBugzilla() {
      $this->beginAt('/xml/home');
      $this->clickLinkWithText('Feedback');
      $this->assertUrlEquals(new URL('http://bugs.xp-framework.net/enter_bug.cgi'));
      $this->assertStatus(HTTP_OK);
    }
  }
?>
