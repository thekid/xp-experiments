<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'tests.AbstractScriptletTestCase',
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
     * Returns a scriptlet that will echo the request object
     *
     */
    protected function newEchoScriptlet() {
      return newinstance('web.Scriptlet', array(), '{
        public function service(ScriptletRequest $request, ScriptletResponse $response) {
          $response->getOutputStream()->write($request->toString());
        }
      }');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function noParameters() {
      $stream= new MemoryOutputStream();
      $this->newEchoScriptlet()->service(
        $this->newRequest(new URL('http://localhost/')), 
        $this->newResponse($stream)
      );
      $this->assertEquals('OK: Request(params{ })', $stream->getBytes());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withParameters() {
      $stream= new MemoryOutputStream();
      $this->newEchoScriptlet()->service(
        $this->newRequest(new URL('http://localhost/?a=b&c=d')), 
        $this->newResponse($stream)
      );
      $this->assertEquals('OK: Request(params{ a="b" c="d" })', $stream->getBytes());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function arrayParameter() {
      $stream= new MemoryOutputStream();
      $this->newEchoScriptlet()->service(
        $this->newRequest(new URL('http://localhost/?a[]=a&a[]=b&a[]=c')), 
        $this->newResponse($stream)
      );
      $this->assertEquals(
        "OK: Request(params{ a=[\n".
        "  0 => \"a\"\n".
        "  1 => \"b\"\n". 
        "  2 => \"c\"\n".
        "] })", 
        $stream->getBytes()
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function mapParameter() {
      $stream= new MemoryOutputStream();
      $this->newEchoScriptlet()->service(
        $this->newRequest(new URL('http://localhost/?a[a]=a&a[b]=b')), 
        $this->newResponse($stream)
      );
      $this->assertEquals(
        "OK: Request(params{ a=[\n".
        "  a => \"a\"\n".
        "  b => \"b\"\n". 
        "] })", 
        $stream->getBytes()
      );
    }
  }
?>
