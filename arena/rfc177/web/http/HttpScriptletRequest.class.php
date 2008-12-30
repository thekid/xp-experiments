<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.URL', 'web.Cookie', 'web.Session', 'web.ScriptletRequest');

  /**
   * Scriptlet request for HTTP scriptlets
   *
   * @purpose  Request
   */
  interface HttpScriptletRequest extends ScriptletRequest {

    /**
     * Retrieve all cookies
     *
     * @return  web.Cookie[]
     */
    public function getCookies();
    
    /**
     * Check whether a cookie exists by a specified name
     *
     * <code>
     *   if ($request->hasCookie('username')) {
     *     with ($c= $request->getCookie('username')); {
     *       $response->write('Welcome back, '.$c->getValue());
     *     }
     *   }
     * </code>
     *
     * @param   string name
     * @return  bool
     */
    public function hasCookie($name);

    /**
     * Retrieve cookie by it's name
     *
     * @param   mixed default default NULL the default value if cookie is non-existant
     * @return  web.Cookie
     */
    public function getCookie($name, $default= NULL);

    /**
     * Returns whether a session exists
     *
     * @return  bool
     */
    public function hasSession();
    
    /**
     * Retrieves the session or NULL if none exists
     *
     * @return  scriptlet.Session session object
     */
    public function getSession();
    
    /**
     * Returns a request header by its name or NULL if there is no such header
     * Typical request headers are: Accept, Accept-Charset, Accept-Encoding,
     * Accept-Language, Connection, Host, Keep-Alive, Referer, User-Agent
     *
     * @param   string name Header
     * @param   mixed default default NULL the default value if header is non-existant
     * @return  string Header value
     */
    public function getHeader($name, $default= NULL);
    
    /**
     * Returns the request method.
     *
     * @return  string
     */
    public function getMethod();
    

    /**
     * Returns the query string from its environment variable 
     * QUERY_STRING, decoding it if necessary.
     *
     * @return  string
     */
    public function getQueryString();

  }
?>
