<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'unittest.web.WebTestCase',
    'io.streams.MemoryInputStream'
  );

  /**
   * WebTestCase tests
   *
   * @see      xp://unittest.web.WebTestCase
   * @purpose  Unittest
   */
  class WebTestCaseTest extends TestCase {
    protected
      $fixture= NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= newinstance('unittest.web.WebTestCase', array($this->name), '{
        protected function getConnection($url= NULL) {
          return new HttpConnection("http://localhost/");
        }
        
        protected function doRequest($method, $params) {
          return $this->response;
        }
        
        public function respondWith($status, $headers= array(), $body= "") {
          $headers[]= "Content-Length: ".strlen($body);
          $this->response= new HttpResponse(new MemoryInputStream(sprintf(
            "HTTP/1.0 %d Message\r\n%s\r\n\r\n%s",
            $status,
            implode("\r\n", $headers),
            $body
          )));
        }
      }');
    }
    
    /**
     * Test an empty document
     *
     */
    #[@test]
    public function emptyDocument() {
      $this->fixture->respondWith(HTTP_OK);

      $this->fixture->beginAt('/');
      $this->fixture->assertStatus(HTTP_OK);
      $this->fixture->assertHeader('Content-Length', '0');
    }

    /**
     * Test assertContentType()
     *
     */
    #[@test]
    public function contentType() {
      $this->fixture->respondWith(HTTP_OK, array('Content-Type: text/html'));

      $this->fixture->beginAt('/');
      $this->fixture->assertContentType('text/html');
    }

    /**
     * Test assertContentType()
     *
     */
    #[@test]
    public function contentTypeWithCharset() {
      $this->fixture->respondWith(HTTP_OK, array('Content-Type: text/xml; charset=utf-8'));

      $this->fixture->beginAt('/');
      $this->fixture->assertContentType('text/xml; charset=utf-8');
    }

    /**
     * Test a very simple error-document
     *
     */
    #[@test]
    public function errorDocument() {
      $this->fixture->respondWith(HTTP_NOT_FOUND, array(), trim('
        <html>
          <head>
            <title>Not found</title>
          </head>
          <body>
            <h1>404: The file you requested was not found</h1>
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertStatus(HTTP_NOT_FOUND);
      $this->fixture->assertTitleEquals('Not found');
      $this->fixture->assertTextPresent('404: The file you requested was not found');
      $this->fixture->assertTextNotPresent('I found it');
    }

    /**
     * Test element presence
     *
     */
    #[@test]
    public function elements() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Elements</title>
          </head>
          <body>
            <div id="header"/>
            <!-- <div id="navigation"/> -->
            <div id="main"/>
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertElementPresent('header');
      $this->fixture->assertElementNotPresent('footer');
      $this->fixture->assertElementPresent('main');
      $this->fixture->assertElementNotPresent('footer');
    }

    /**
     * Test images presence
     *
     */
    #[@test]
    public function images() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Images</title>
          </head>
          <body>
            <img src="/static/blank.gif"/>
            <!-- <img src="http://example.com/example.png"/> -->
            <img src="http://example.com/logo.jpg"/>
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertImagePresent('/static/blank.gif');
      $this->fixture->assertImageNotPresent('http://example.com/example.png');
      $this->fixture->assertImageNotPresent('logo.jpg');
      $this->fixture->assertImagePresent('http://example.com/logo.jpg');
    }

    /**
     * Test link presence
     *
     */
    #[@test]
    public function links() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Links</title>
          </head>
          <body>
            <a href="http://example.com/test">Test</a>
            <a href="/does-not-exist">404</a>
            <!-- <a href="comment.html">Hidden</a> -->
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertLinkPresent('http://example.com/test');
      $this->fixture->assertLinkPresent('/does-not-exist');
      $this->fixture->assertLinkNotPresent('comment.html');
      $this->fixture->assertLinkNotPresent('index.html');
    }

    /**
     * Test link presence
     *
     */
    #[@test]
    public function linksWithText() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Links</title>
          </head>
          <body>
            <a href="http://example.com/test">Test</a>
            <a href="/does-not-exist">404</a>
            <!-- <a href="comment.html">Hidden</a> -->
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertLinkPresentWithText('Test');
      $this->fixture->assertLinkPresentWithText('404');
      $this->fixture->assertLinkNotPresentWithText('Hidden');
      $this->fixture->assertLinkNotPresentWithText('Hello');
    }

    /**
     * Test forms
     *
     */
    #[@test]
    public function unnamedForm() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Enter your name</title>
          </head>
          <body>
            <form action="http://example.com/">
              <input type="text" name="name"/>
            </form>
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertFormPresent();
    }

    /**
     * Test forms
     *
     */
    #[@test]
    public function noForm() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Enter your name</title>
          </head>
          <body>
            <!-- TODO: Add form -->
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertFormNotPresent();
    }

    /**
     * Test forms
     *
     */
    #[@test]
    public function namedForms() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Blue or red pill?</title>
          </head>
          <body>
            <form name="blue" action="http://example.com/one">
              <input type="text" name="name"/>
            </form>
            <form name="red" action="http://example.com/two">
              <input type="text" name="name"/>
            </form>
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');
      $this->fixture->assertFormPresent('red');
      $this->fixture->assertFormPresent('blue');
      $this->fixture->assertFormNotPresent('green');
    }
    
    /**
     * Assertion helper
     *
     * @param   string action
     * @param   string method
     * @param   unittest.web.Field[] fields
     * @param   unittest.web.Form form
     * @throws  unittest.AssertionFailedError  
     */
    protected function assertForm($action, $method, $fields, $form) {
      $this->assertClass($form, 'unittest.web.Form');
      $this->assertEquals($action, $form->getAction());
      $this->assertEquals($method, $form->getMethod());
      $this->assertEquals($fields, $form->getFields());
    }

    /**
     * Test forms
     *
     */
    #[@test]
    public function getForm() {
      $this->fixture->respondWith(HTTP_OK, array(), trim('
        <html>
          <head>
            <title>Form-Mania!</title>
          </head>
          <body>
            <form name="one" action="http://example.com/one"></form>
            <form name="two" method="POST" action="http://example.com/two"></form>
            <form name="three"></form>
          </body>
        </html>
      '));

      $this->fixture->beginAt('/');

      $this->assertForm(
        'http://example.com/one', HTTP_GET, array(), 
        $this->fixture->getForm('one')
      );
      $this->assertForm(
        'http://example.com/two', HTTP_POST, array(), 
        $this->fixture->getForm('two')
      );
      $this->assertForm(
        '/', HTTP_GET, array(), 
        $this->fixture->getForm('three')
      );
    }
  }
?>
