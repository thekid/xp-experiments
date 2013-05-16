<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.OutputStream');

  /**
   * Defines the response sent by the server to the client
   *
   * @purpose  Interface
   */  
  interface ScriptletResponse {

    /**
     * Set request this response is to.
     *
     * @param   web.scriptlet.ScriptletRequest r
     */
    public function setRequest(ScriptletRequest $r);

    /**
     * Sets the length of the content body in the response. 
     *
     * @param   int length
     */
    public function setContentLength($length);

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string type
     */
    public function setContentType($type);

    /**
     * Sets the content type of the response being sent to the client.
     *
     * @param   string encoding
     */
    public function setCharacterEncoding($encoding);

    /**
     * Commit this response
     *
     */
    public function commit();

    /**
     * Returns whether the response has been comitted yet.
     *
     * @return  bool
     */
    public function isCommitted();

    /**
     * Gets the output stream
     *
     * @param   io.streams.OutputStream
     */
    public function getOutputStream();

    /**
     * Sets status code
     *
     * @param   int sc statuscode
     * @see     rfc://2616#10
     */
    public function setStatus($sc);
    
    /**
     * Send an error
     *
     * @param   int sc
     * @param   string message
     */
    public function sendError($sc, $message);

    /**
     * Send a redirect
     *
     * @param   peer.URL target
     */
    public function sendRedirect(URL $url);

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
    public function addCookie($cookie);

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
    public function addHeader($name, $value);
  }
?>
