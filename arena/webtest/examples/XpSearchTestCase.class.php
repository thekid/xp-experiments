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
   * @see      http://planet-xp.net/xml/search
   * @purpose  Web test case
   */
  class XpSearchTestCase extends WebTestCase {

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
    public function searchFunction() {
      $this->beginAt('/xml/home');
      $form= $this->getForm();
      $form->getField('query')->setValue('Unittest');
      $form->submit();
      $this->assertStatus(HTTP_OK);
      $this->assertTitleEquals('Search for "Unittest" - XP Framework');
    }
  }
?>
