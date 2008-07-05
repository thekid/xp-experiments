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
  abstract class WebTestCase extends TestCase {
    protected
      $conn     = NULL,
      $response = NULL;
    
    private
      $dom      = NULL,
      $xpath    = NULL;
    
    /**
     * Get connection
     *
     * @param   string url
     * @return  peer.http.HttpConnection
     */
    protected abstract function getConnection($url= NULL);

    /**
     * Set up this test case. Creates connection.
     *
     */
    public function __construct($name, $url= NULL) {
      parent::__construct($name);
      $this->conn= $this->getConnection($url);
    }
    
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
     * Assert a the "Content-Type" HTTP header is equ
     *
     * @param   string ctype
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertContentType($ctype, $message= 'not_equals') {
      $this->assertEquals($ctype, $this->response->getHeader('Content-Type'), $message);
    }

    /**
     * Assert a HTTP header key / value pair
     *
     * @param   string header
     * @param   string value
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertHeader($header, $value, $message= 'not_equals') {
      $this->assertEquals($value, $this->response->getHeader($header), $message);
    }

    /**
     * Assert an element is present
     *
     * @param   string id
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertElementPresent($id, $message= 'not_present') {
      $node= $this->getXPath()->query('//*[@id = "'.$id.'"]')->item(0);
      $this->assertNotEquals(NULL, $node, $message);
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
     * Assert an image is present
     *
     * @param   string src
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertImagePresent($src, $message= 'not_present') {
      $node= $this->getXPath()->query('//img[@src = "'.$src.'"]')->item(0);
      $this->assertNotEquals(NULL, $node, $message);
    }

    /**
     * Assert a link to a specified URL is present
     *
     * @param   string url
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertLinkPresent($url, $message= 'not_present') {
      $node= $this->getXPath()->query('//a[@href = "'.$url.'"]')->item(0);
      $this->assertNotEquals(NULL, $node, $message);
    }
    
    /**
     * Assert a link with a specific text is present
     *
     * @param   string text
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertLinkPresentWithText($text, $message= 'not_present') {
      $node= $this->getXPath()->query('//a[text() = "'.$text.'"]')->item(0);
      $this->assertNotEquals(NULL, $node, $message);
    }

    /**
     * Assert a form is present
     *
     * @param   string name default NULL
     * @param   string message
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertFormPresent($name= NULL, $message= 'not_present') {
      $node= $this->getXPath()->query($name ? '//form[@name = "'.$name.'"]' : '//form')->item(0);
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
