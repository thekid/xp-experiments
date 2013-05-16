<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('web.scriptlet.ScriptletResponse');

  /**
   * Wraps a response - that is, delegates all calls to the wrapped response
   * object.
   *
   * @purpose  Response implementation
   */  
  abstract class ResponseWrapper extends Object implements ScriptletResponse {
    protected $wrapped= NULL;
      
    /**
     * Constructor
     *
     * @param   web.scriptlet.ScriptletResponse wrapped
     */
    public function __construct(ScriptletResponse $wrapped) {
      $this->wrapped= $wrapped;
    }

    /**
     * Set request this response is to.
     *
     * @param   web.scriptlet.ScriptletRequest r
     */
    public function setRequest(ScriptletRequest $r) {
      $this->wrapped->setRequest($r);
    }

    /**
     * Sets the length of the content body in the response. 
     *
     * @param   int length
     */
    public function setContentLength($length) {
      return $this->wrapped->setContentLength($length);
    }

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string type
     */
    public function setContentType($type) {
      return $this->wrapped->setContentType($type);
    }

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string encoding
     */
    public function setCharacterEncoding($encoding) {
      return $this->wrapped->setCharacterEncoding($encoding);
    }

    /**
     * Commits this response
     *
     * @return  bool
     */
    public function commit() {
      $this->wrapped->commit();
    }

    /**
     * Returns whether the response has been comitted yet.
     *
     * @return  bool
     */
    public function isCommitted() {
      return $this->wrapped->isCommitted();
    }

    /**
     * Gets the output stream
     *
     * @param   io.streams.OutputStream
     */
    public function getOutputStream() {
      return $this->wrapped->getOutputStream();
    }

    /**
     * Flushes this response, that is, writes all headers to the outputstream
     *
     */
    public function flush() {
      return $this->wrapped->flush();
    }

    /**
     * Returns a string representation of this response wrapper
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(->'.$this->wrapped->toString().')';
    }

    /**
     * Sets status code
     *
     * @param   int sc statuscode
     * @see     rfc://2616#10
     */
    public function setStatus($sc) {
      $this->wrapped->setStatus($sc);
    }
    
    /**
     * Send an error
     *
     * @param   int sc
     * @param   string message
     */
    public function sendError($sc, $message) {
      $this->wrapped->sendError($sc, $message);
    }

    /**
     * Send a redirect
     *
     * @param   peer.URL target
     */
    public function sendRedirect(URL $url) {
      $this->wrapped->sendRedirect($sc, $message);
    }

    /**
     * Set a cookie. May be called multiple times with different cookies
     * to set more than one cookie.
     *
     * Example:
     * <code>
     *   $response->addCookie(new Cookie('lastvisit', date('Y-m-d')));
     * </code>
     *
     * @param   web.scriptlet.Cookie cookie
     */
    public function addCookie($cookie) {
      return $this->wrapped->setCookie($cookie);
    }

    /**
     * Adds a response header. If this header is already set, it will
     * be overwritten. Multiple headers *are* allowed but quite useless
     * for most applications.
     *
     * Example:
     * <code>
     *   $response->addHeader('X-Binford', '6100 (more power)');
     * </code>
     *
     * @param   string name header name
     * @param   string value header value
     */
    public function addHeader($name, $value) {
      return $this->wrapped->setHeader($name, $value);
    }
  }
?>
