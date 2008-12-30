<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.URL', 'web.Cookie', 'web.ScriptletResponse');

  /**
   * Scriptlet response for HTTP scriptlets
   *
   * @purpose  Response
   */
  interface HttpScriptletResponse extends ScriptletResponse {

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
     * @param   web.Cookie cookie
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
