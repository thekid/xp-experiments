<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.URL',
    'io.streams.OutputStream',
    'web.scriptlet.Scriptlet',
    'web.scriptlet.ScriptletRequest',
    'web.scriptlet.ScriptletResponse',
    'web.scriptlet.ScriptletOutputStream'
  );

  /**
   * Base class for scriptlet tests
   *
   * @purpose  Abstract base class
   */
  abstract class AbstractScriptletTestCase extends TestCase {

    /**
     * Returns a new request with a given URL
     *
     * @param   peer.URL url
     * @return  web.scriptlet.ScriptletRequest
     */
    protected function newHttpRequest($method, URL $url) {
      return newinstance('web.scriptlet.ScriptletRequest', array($method, $url), '{
        private $url, $method;
        
        public function __construct($method, URL $url) {
          $this->method= $method;
          $this->url= $url;
        }
        public function getInputStream() { }
        public function getCookies() { }
        public function hasCookie($name) { }
        public function getCookie($name, $default= NULL) { }
        public function hasSession() { }
        public function getSession() { }
        public function getHeader($name, $default= NULL) { }
        public function getMethod() { return $this->method; }
        public function getQueryString() { }
        public function getContentLength() { }
        public function getContentType() { }
        public function getCharacterEncoding() { }
        public function getParam($name, $default= NULL) { 
          return $this->url->getParam($name, $default);
        }
        public function hasParam($name) { 
          return $this->url->hasParam($name);
        }
        public function getParams() { 
          return $this->url->getParams();
        }
        public function getURL() { 
          return $this->url;
        }
        public function toString() {
          $s= "Request(params{ ";
          foreach ($this->url->getParams() as $key => $value) {
            $s.= $key."=".xp::stringOf($value)." ";
          }
          return $s."})";
        }
      }');
    }

    /**
     * Returns a new response with a given output stream
     *
     * @param   io.streams.OutputStream
     * @return  web.scriptlet.ScriptletResponse
     */
    protected function newHttpResponse(OutputStream $stream) {
      return newinstance('web.scriptlet.ScriptletResponse', array($stream), '{
        private $stream;
        private $status= 200;
        private $headers= array("Content-Type" => "text/html");
        public function __construct(OutputStream $stream) {
          $this->stream= new ScriptletOutputStream($stream, $this);
        }
        public function setRequest(ScriptletRequest $r) {
        }
        public function setContentLength($length) { 
          $this->headers["Content-Length"]= $length;
        }
        public function setContentType($type) {
          $this->headers["Content-Type"]= $type;
        }
        public function setCharacterEncoding($encoding) {
          $this->headers["Content-Type"].= "; charset= ".$encoding;
        }
        public function commit() {
          $this->stream->write($this->status." { ");
          foreach ($this->headers as $key => $value) {
            $this->stream->write($key."=".xp::stringOf($value)." ");
          }
          $this->stream->write("} : ");
        }
        public function isCommitted() { }
        public function getOutputStream() {
          return $this->stream;
        }
        public function flush() { }
        public function setStatus($sc) { 
          $this->status= $sc; 
        }
        public function sendError($sc, $message) { 
          $this->setStatus($sc);
          $this->setContentType("text/html");
          $this->getOutputStream()->write("<h1>".$message."</h1>");
        }
        public function sendRedirect(URL $url) { 
          $this->setStatus(302);
          unset($this->headers["Content-Type"]);
          unset($this->headers["Content-Length"]);
          $this->addHeader("Location", $url->getUrl());
          $this->getOutputStream()->close();
        }
        public function addCookie($cookie) { 
          $this->headers["Set-Cookie"]= $cookie->getHeaderValue();
        }
        public function addHeader($name, $value) { 
          $this->headers[$name]= $value;
        }
      }');      
    }
  }
?>
