<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.http.HttpConnection',
    'peer.http.HttpConstants',
    'xml.XPath'
  );

  /**
   * TestCase for web sites
   *
   * @see      xp://unittest.TestCase
   * @purpose  Integration tests
   */
  class WebTestCase extends TestCase {
    protected
      $conn     = NULL,
      $response = NULL;
    
    private
      $dom      = NULL,
      $xpath    = NULL;
      
    /**
     * Returns a DOM object for this response's contents. Lazy/Cached.
     *
     * @return  php.DOMDocument
     */
    protected function getDom() {
      if (NULL === $this->dom) {
        $contents= '';
        while ($chunk= $this->response->readData()) {
          $contents.= $chunk;
        }
        $this->dom= new DOMDocument();
        @$this->dom->loadHTML($contents);
      }
      return $this->dom;
    }

    /**
     * Returns an XPath object on this response's DOM. Lazy/Cached.
     *
     * @return  xml.XPath
     */
    protected function getXPath() {
      if (NULL === $this->xpath) {
        $this->xpath= new XPath($this->getDom());
      }
      return $this->xpath;
    }
  
    /**
     * Assert on the HTML title element
     *
     * @param   string relative
     * @throws  unittest.AssertionFailedError  
     */
    protected function beginAt($relative) {
      $this->dom= NULL;
      $this->xpath= NULL;
      try {
        $this->response= $this->conn->get($relative);
      } catch (IOException $e) {
        $this->fail($relative, $e, NULL);
      }
    }

    /**
     * Assert a HTTP status code
     *
     * @param   int status
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertStatus($status, $message= 'not_equals') {
      $this->assertEquals($status, $this->response->getStatusCode(), $message);
    }
    
    /**
     * Assert a text is present
     *
     * @param   string text
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertTextPresent($text, $message= 'not_present') {
      $node= $this->getXPath()->query('//*[text() = "'.$text.'"]')->item(0);
      $this->assertNotEquals(NULL, $node, $message);
    }

    /**
     * Assert on the HTML title element
     *
     * @param   string title
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertTitleEquals($title, $message= 'not_equals') {
      $text= $this->getXPath()->query('//title/text()')->item(0);
      $this->assertEquals($title, $text->data, $message);
    }
  }
?>
