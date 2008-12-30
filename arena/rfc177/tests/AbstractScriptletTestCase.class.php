<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'peer.URL',
    'io.streams.OutputStream',
    'web.Scriptlet',
    'web.ScriptletRequest',
    'web.ScriptletResponse',
    'web.ScriptletOutputStream'
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
     * @return  web.ScriptletRequest
     */
    protected function newRequest(URL $url) {
      return newinstance('web.ScriptletRequest', array($url), '{
        private $url;
        public function __construct(URL $url) {
          $this->url= $url;
        }
        public function getContentLength() { }
        public function getContentType() { }
        public function getCharacterEncoding() { }
        public function getParam($name, $default= NULL) { }
        public function hasParam($name) { }
        public function getParams() { }
        public function getURL() { }
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
     * @return  web.ScriptletResponse
     */
    protected function newResponse(OutputStream $stream) {
      return newinstance('web.ScriptletResponse', array($stream), '{
        private $stream;
        public function __construct(OutputStream $stream) {
          $this->stream= new ScriptletOutputStream($stream, $this);
        }
        public function setContentLength($length) { }
        public function setContentType($type) { }
        public function setCharacterEncoding($encoding) { }
        public function commit() {
          $this->stream->write("OK: ");
        }
        public function isCommitted() { }
        public function getOutputStream() {
          return $this->stream;
        }
        public function flush() { }
      }');      
    }
  }
?>
