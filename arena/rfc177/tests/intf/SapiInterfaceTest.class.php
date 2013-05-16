<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'io.streams.MemoryInputStream',
    'web.scriptlet.intf.sapi.Request'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class SapiInterfaceTest extends TestCase {
  
    /**
     * Returns a GET request
     *
     */
    protected function getRequest() {
      $r= new web新criptlet搏ntf新api愛equest();
      $r->extract(
        array(                    // _ENV
          'DOCUMENT_ROOT' => '/home/www/htdocs',
          'HTTP_ACCEPT' => 'image/gif, image/jpeg, image/pjpeg, application/x-ms-application, application/vnd.ms-xpsdocument, application/xaml+xml, application/x-ms-xbap, application/x-shockwave-flash, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/msword, application/x-silverlight, */*',
          'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
          'HTTP_ACCEPT_LANGUAGE' => 'de',
          'HTTP_CONNECTION' => 'Keep-Alive',
          'HTTP_COOKIE' => 'name=Timm',
          'HTTP_HOST' => 'example.com',
          'HTTP_REFERER' => 'http://example.com/scriptlet/test',
          'HTTP_UA_CPU' => 'x86',
          'HTTP_USER_AGENT' => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30618)',
          'PATH' => '/bin:/usr/bin',
          'REDIRECT_QUERY_STRING' => 'name=Timm',
          'REDIRECT_SCRIPT_URI' => 'http://example.com/scriptlet/test',
          'REDIRECT_SCRIPT_URL' => '/scriptlet/test',
          'REDIRECT_STATUS' => '200',
          'REDIRECT_UNIQUE_ID' => 'SV@8S9TjbaUAAHeSPGA',
          'REDIRECT_URL' => '/scriptlet/test',
          'REMOTE_ADDR' => '92.205.34.144',
          'REMOTE_PORT' => '51096',
          'SCRIPT_FILENAME' => '/home/www/htdocs/scriptlet/test',
          'SCRIPT_URI' => 'http://example.com/scriptlet/test',
          'SCRIPT_URL' => '/scriptlet/test',
          'SERVER_ADDR' => '208.77.188.166',
          'SERVER_ADMIN' => 'webmaster@example.com',
          'SERVER_NAME' => 'example.com',
          'SERVER_PORT' => '80',
          'SERVER_SIGNATURE' => '',
          'SERVER_SOFTWARE' => 'Apache',
          'UNIQUE_ID' => 'SV@8S9TjbaUAAHeSPGA',
          'GATEWAY_INTERFACE' => 'CGI/1.1',
          'SERVER_PROTOCOL' => 'HTTP/1.1',
          'REQUEST_METHOD' => 'GET',
          'QUERY_STRING' => 'name=Timm',
          'REQUEST_URI' => '/scriptlet/test?name=Timm',
          'SCRIPT_NAME' => '/scriptlet/test',
          'PATH_INFO' => '/scriptlet/test',
          'PATH_TRANSLATED' => '/home/www/htdocs/scriptlet/test',
          'STATUS' => '200',
        ), 
        array(                    // _COOKIE
        ),
        array(                    // _GET
          'name'             => 'Timm'
        ),
        new MemoryInputStream('')
      );
      return $r;
    }

    /**
     * Returns a POST request
     *
     */
    protected function postRequest() {
      $r= new web新criptlet搏ntf新api愛equest();
      $r->extract(
        array(                    // _ENV
          'CONTENT_LENGTH' => '9',
          'CONTENT_TYPE' => 'application/x-www-form-urlencoded',
          'DOCUMENT_ROOT' => '/home/www/htdocs',
          'HTTP_ACCEPT' => 'image/gif, image/jpeg, image/pjpeg, application/x-ms-application, application/vnd.ms-xpsdocument, application/xaml+xml, application/x-ms-xbap, application/x-shockwave-flash, application/vnd.ms-excel, application/vnd.ms-powerpoint, application/msword, application/x-silverlight, */*',
          'HTTP_ACCEPT_ENCODING' => 'gzip, deflate',
          'HTTP_ACCEPT_LANGUAGE' => 'de',
          'HTTP_CACHE_CONTROL' => 'no-cache',
          'HTTP_CONNECTION' => 'Keep-Alive',
          'HTTP_HOST' => 'example.com',
          'HTTP_REFERER' => 'http://example.com/scriptlet/test',
          'HTTP_UA_CPU' => 'x86',
          'HTTP_USER_AGENT' => 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0; Trident/4.0; SLCC1; .NET CLR 2.0.50727; Media Center PC 5.0; .NET CLR 3.5.30729; .NET CLR 3.0.30618)',
          'PATH' => '/bin:/usr/bin',
          'REDIRECT_SCRIPT_URI' => 'http://example.com/scriptlet/test',
          'REDIRECT_SCRIPT_URL' => '/scriptlet/test',
          'REDIRECT_STATUS' => '200',
          'REDIRECT_UNIQUE_ID' => 'SV@74tTjbaUAAHbRjNU',
          'REDIRECT_URL' => '/scriptlet/test',
          'REMOTE_ADDR' => '92.205.34.144',
          'REMOTE_PORT' => '51093',
          'SCRIPT_FILENAME' => '/home/www/htdocs/scriptlet/test',
          'SCRIPT_URI' => 'http://example.com/scriptlet/test',
          'SCRIPT_URL' => '/scriptlet/test',
          'SERVER_ADDR' => '208.77.188.166',
          'SERVER_ADMIN' => 'webmaster@example.com',
          'SERVER_NAME' => 'example.com',
          'SERVER_PORT' => '80',
          'SERVER_SIGNATURE' => '',
          'SERVER_SOFTWARE' => 'Apache',
          'UNIQUE_ID' => 'SV@74tTjbaUAAHbRjNU',
          'GATEWAY_INTERFACE' => 'CGI/1.1',
          'SERVER_PROTOCOL' => 'HTTP/1.1',
          'REQUEST_METHOD' => 'POST',
          'QUERY_STRING' => '',
          'REQUEST_URI' => '/scriptlet/test',
          'SCRIPT_NAME' => '/scriptlet/test',
          'PATH_INFO' => '/scriptlet/test',
          'PATH_TRANSLATED' => '/home/www/htdocs/scriptlet/test',
          'STATUS' => '200',
        ), 
        array(                    // _COOKIE
        ),
        array(                    // _POST
          'name'             => 'Timm'
        ),
        new MemoryInputStream('')
      );
      return $r;
    }
    
    /**
     * Test getMethod()
     *
     */
    #[@test]
    public function method() {
      $this->assertEquals('GET', $this->getRequest()->getMethod(), 'GET');
      $this->assertEquals('POST', $this->postRequest()->getMethod(), 'POST');
    }

    /**
     * Test getQueryString()
     *
     */
    #[@test]
    public function queryString() {
      $this->assertEquals('name=Timm', $this->getRequest()->getQueryString(), 'GET');
      $this->assertEquals('', $this->postRequest()->getQueryString(), 'POST');
    }

    /**
     * Test hasParam()
     *
     */
    #[@test]
    public function hasParam() {
      $this->assertTrue($this->getRequest()->hasParam('name'), 'GET');
      $this->assertTrue($this->postRequest()->hasParam('name'), 'POST');
    }

    /**
     * Test getParam()
     *
     */
    #[@test]
    public function param() {
      $this->assertEquals('Timm', $this->getRequest()->getParam('name'), 'GET');
      $this->assertEquals('Timm', $this->postRequest()->getParam('name'), 'POST');
    }

    /**
     * Test getParam()
     *
     */
    #[@test]
    public function nonExistantParam() {
      $this->assertNull($this->getRequest()->getParam('@non-existant@'), 'GET');
      $this->assertNull($this->postRequest()->getParam('@non-existant@'), 'POST');
    }

    /**
     * Test getParam()
     *
     */
    #[@test]
    public function defaultParam() {
      with ($default= 'World'); {
        $this->assertEquals($default, $this->getRequest()->getParam('hello', $default), 'GET');
        $this->assertEquals($default, $this->postRequest()->getParam('hello', $default), 'POST');
      }
    }

    /**
     * Test getParam()
     *
     */
    #[@test]
    public function params() {
      with ($params= array('name' => 'Timm')); {
        $this->assertEquals($params, $this->getRequest()->getParams(), 'GET');
        $this->assertEquals($params, $this->postRequest()->getParams(), 'POST');
      }
    }
    
    /**
     * Test getHeader()
     *
     */
    #[@test]
    public function header() {
      $this->assertEquals('gzip, deflate', $this->getRequest()->getHeader('Accept-Encoding'), 'GET');
      $this->assertEquals('gzip, deflate', $this->postRequest()->getHeader('Accept-Encoding'), 'POST');
    }

    /**
     * Test getHeader()
     *
     */
    #[@test]
    public function nonExistantHeader() {
      $this->assertNull($this->getRequest()->getHeader('@non-existant@'), 'GET');
      $this->assertNull($this->postRequest()->getHeader('@non-existant@'), 'POST');
    }

    /**
     * Test getContentType()
     *
     */
    #[@test]
    public function contentType() {
      $this->assertEquals(NULL, $this->getRequest()->getContentType(), 'GET');
      $this->assertEquals('application/x-www-form-urlencoded', $this->postRequest()->getContentType(), 'POST');
    }

    /**
     * Test getContentType()
     *
     */
    #[@test]
    public function contentLength() {
      $this->assertEquals(0, $this->getRequest()->getContentLength(), 'GET');
      $this->assertEquals(9, $this->postRequest()->getContentLength(), 'POST');
    }

    /**
     * Test getQueryString()
     *
     */
    #[@test]
    public function url() {
      $this->assertEquals(new URL('http://example.com/scriptlet/test'), $this->getRequest()->getURL(), 'GET');
      $this->assertEquals(new URL('http://example.com/scriptlet/test'), $this->postRequest()->getURL(), 'POST');
    }

    /**
     * Test getRemoteAddr()
     *
     */
    #[@test]
    public function remoteAddr() {
      $this->assertEquals('92.205.34.144', $this->getRequest()->getRemoteAddr(), 'GET');
      $this->assertEquals('92.205.34.144', $this->postRequest()->getRemoteAddr(), 'POST');
    }

    /**
     * Test getRemoteHost()
     *
     */
    #[@test]
    public function remoteHost() {
      $this->assertEquals(NULL, $this->getRequest()->getRemoteHost(), 'GET');
      $this->assertEquals(NULL, $this->postRequest()->getRemoteHost(), 'POST');
    }

    /**
     * Test getRemotePort()
     *
     */
    #[@test]
    public function remotePort() {
      $this->assertEquals(51096, $this->getRequest()->getRemotePort(), 'GET');
      $this->assertEquals(51093, $this->postRequest()->getRemotePort(), 'POST');
    }

    /**
     * Test getRemoteUser()
     *
     */
    #[@test]
    public function remoteUser() {
      $this->assertEquals(NULL, $this->getRequest()->getRemoteUser(), 'GET');
      $this->assertEquals(NULL, $this->postRequest()->getRemoteUser(), 'POST');
    }

    /**
     * Test getServerName()
     *
     */
    #[@test]
    public function serverName() {
      $this->assertEquals('example.com', $this->getRequest()->getServerName(), 'GET');
      $this->assertEquals('example.com', $this->postRequest()->getServerName(), 'POST');
    }

    /**
     * Test getServerPort()
     *
     */
    #[@test]
    public function serverPort() {
      $this->assertEquals(80, $this->getRequest()->getServerPort(), 'GET');
      $this->assertEquals(80, $this->postRequest()->getServerPort(), 'POST');
    }
  }
?>
