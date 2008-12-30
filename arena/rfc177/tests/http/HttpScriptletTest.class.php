<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'tests.http.AbstractHttpScriptletTestCase',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class HttpScriptletTest extends AbstractHttpScriptletTestCase {

    /**
     * Returns a scriptlet without implementation
     *
     */
    protected function noImplScriptlet() {
      return newinstance('web.http.HttpScriptlet', array(), '{ }');
    }

    /**
     * Returns a scriptlet with implementation
     *
     */
    protected function newScriptlet() {
      return newinstance('web.http.HttpScriptlet', array(), '{ 
        protected function doGet(HttpScriptletRequest $request, HttpScriptletResponse $response) {
          $response->getOutputStream()->write("<h1>Enter your name</h1>");
        }

        protected function doPost(HttpScriptletRequest $request, HttpScriptletResponse $response) {
          $response->getOutputStream()->write("<h1>Hello ".$request->getParam("name")."</h1>");
        }
      }');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function notImplemented() {
      foreach (array('GET', 'HEAD', 'POST') as $method) {
        $stream= new MemoryOutputStream();
        $this->noImplScriptlet()->service(
          $this->newHttpRequest($method, new URL('http://localhost/?a=b&c=d')), 
          $this->newHttpResponse($stream)
        );
        $this->assertEquals('400 { Content-Type="text/html" } : <h1>Method "'.$method.'" not supported</h1>', $stream->getBytes(), $method);
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function enter() {
      $stream= new MemoryOutputStream();
      $this->newScriptlet()->service(
        $this->newHttpRequest('GET', new URL('http://localhost/')), 
        $this->newHttpResponse($stream)
      );
      $this->assertEquals('200 { Content-Type="text/html" } : <h1>Enter your name</h1>', $stream->getBytes());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function hello() {
      $stream= new MemoryOutputStream();
      $this->newScriptlet()->service(
        $this->newHttpRequest('POST', new URL('http://localhost/?name=World')), 
        $this->newHttpResponse($stream)
      );
      $this->assertEquals('200 { Content-Type="text/html" } : <h1>Hello World</h1>', $stream->getBytes());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function redirection() {
      $stream= new MemoryOutputStream();
      newinstance('web.http.HttpScriptlet', array(), '{
        protected function doGet(HttpScriptletRequest $request, HttpScriptletResponse $response) {
          $response->sendRedirect(new URL("http://example.com/"));
        }
      }')->service(
        $this->newHttpRequest('GET', new URL('http://localhost/')), 
        $this->newHttpResponse($stream)
      );
      $this->assertEquals('302 { Location="http://example.com/" } : ', $stream->getBytes());
    }
  }
?>
