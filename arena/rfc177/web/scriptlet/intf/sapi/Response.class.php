<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'web.scriptlet.intf.sapi';
  
  uses('web.scriptlet.ScriptletResponse');

  /**
   * ScriptletResponse implementation for PHP's Server APIs ("SAPI").
   *
   * @see      xp://web.scriptlet.ScriptletResponse
   */
  class web·scriptlet·intf·sapi·Response extends Object implements ScriptletResponse {
    protected $committed= FALSE;
    protected $headers= array();
    protected $status= 200;
    
    /**
     * Set request this response is to.
     *
     * @param   web.scriptlet.ScriptletRequest r
     */
    public function setRequest(ScriptletRequest $r) {
      $this->request= $r;
    }

    /**
     * Sets the length of the content body in the response. 
     *
     * @param   int length
     */
    public function setContentLength($length) {
      $this->headers['Content-Length']= array($length);
    }

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string type
     */
    public function setContentType($type) {
      if (!isset($this->headers['Content-Type'])) {
        $this->headers['Content-Type']= array();
      }
      $this->headers['Content-Type'][0][0]= $type;
    }

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string encoding
     */
    public function setCharacterEncoding($encoding) {
      if (!isset($this->headers['Content-Type'])) {
        $this->headers['Content-Type']= array();
      }
      $this->headers['Content-Type'][0][1]= 'charset= '.$encoding;
    }
    
    /**
     * Send status line (e.g. "HTTP/1.1 200 OK")
     *
     */
    protected function sendStatus() {
      header($this->r->getProtocol().' '.$this->status);
    }

    /**
     * Commit this response
     *
     */
    public function commit() {
      $this->sendStatus();
      foreach ($this->headers as $name => $values) {
        foreach ($values as $value) {
          header(
            $name.': '.strtr(
              is_array($value) ? implode('; ', $value) : $value, 
              array("\r" => '', "\n" => "\n\t")
            ), 
            FALSE
          );
        }
      }
      $this->committed= TRUE;
    }

    /**
     * Returns whether the response has been comitted yet.
     *
     * @return  bool
     */
    public function isCommitted() {
      return $this->committed;
    }

    /**
     * Gets the output stream
     *
     * @param   io.streams.OutputStream
     */
    public function getOutputStream() {
      return new ChannelOutputStream('output');
    }

    /**
     * Sets status code
     *
     * @param   int sc statuscode
     * @see     rfc://2616#10
     */
    public function setStatus($sc) {
      $this->status= $sc;
    }
    
    /**
     * Send an error
     *
     * @param   int sc
     * @param   string message
     */
    public function sendError($sc, $message) {
      $this->status= $sc;
    }

    /**
     * Send a redirect
     *
     * @param   peer.URL target
     * @param   bool permanent default FALSE
     */
    public function sendRedirect(URL $url, $permanent= FALSE) {
      $this->status= $permanent ? 301 : 302;
      $this->headers['Location']= $url->getURL();
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
      $this->addHeader('Set-Cookie', $cookie->getHeaderValue());
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
      if (!isset($this->headers[$name])) {
        $this->headers[$name]= array();
      }
      $this->headers[$name][]= $value;
    }
  }
?>
