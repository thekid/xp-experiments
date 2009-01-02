<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'tests.AbstractScriptletTestCase',
    'web.scriptlet.GenericScriptlet',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class ScriptletTest extends AbstractScriptletTestCase {
  
    /**
     * Returns a scriptlet without implementation
     *
     */
    protected function noImplScriptlet() {
      return newinstance('web.scriptlet.GenericScriptlet', array(), '{ }');
    }

    /**
     * Returns a scriptlet with implementation
     *
     */
    protected function newScriptlet() {
      return newinstance('web.scriptlet.GenericScriptlet', array(), '{ 
        protected function doGet(ScriptletRequest $request, ScriptletResponse $response) {
          $response->getOutputStream()->write("<h1>Enter your name</h1>");
        }

        protected function doPost(ScriptletRequest $request, ScriptletResponse $response) {
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
      $redirect= newinstance('web.scriptlet.GenericScriptlet', array(), '{
        protected function doGet(ScriptletRequest $request, ScriptletResponse $response) {
          $response->sendRedirect(new URL("http://example.com/"));
        }
      }');
      
      $redirect->service(
        $this->newHttpRequest('GET', new URL('http://localhost/')), 
        $this->newHttpResponse($stream)
      );
      $this->assertEquals('302 { Location="http://example.com/" } : ', $stream->getBytes());
    }
  }
?>
