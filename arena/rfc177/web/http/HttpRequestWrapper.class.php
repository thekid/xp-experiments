<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('web.RequestWrapper', 'web.http.HttpScriptletRequest');

  /**
   * Wraps a request - that is, delegates all calls to the wrapped request
   * object.
   *
   * @purpose  Request implementation
   */  
  class HttpRequestWrapper extends RequestWrapper implements HttpScriptletRequest {
  
    /**
     * Constructor
     *
     * @param   web.http.HttpScriptletRequest wrapped
     */
    public function __construct(HttpScriptletRequest $wrapped) {
      parent::__construct($wrapped);
    }

    /**
     * Returns whether a session exists
     *
     * @return  bool
     */
    public function hasSession() {
      return $this->wrapped->hasSession();
    }
    
    /**
     * Retrieves the session or NULL if none exists
     *
     * @return  web.Session session object
     */
    public function getSession() {
      return $this->wrapped->getSession();
    }
    
    /**
     * Retrieve all cookies
     *
     * @return  web.Cookie[]
     */
    public function getCookies() {
      return $this->wrapped->getCookies();
    }
    
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
    public function hasCookie($name) {
      return $this->wrapped->hasCookie($name);
    }

    /**
     * Retrieve cookie by it's name
     *
     * @param   mixed default default NULL the default value if cookie is non-existant
     * @return  web.Cookie
     */
    public function getCookie($name, $default= NULL) {
      return $this->wrapped->getCookie($name, $default);
    }

    /**
     * Returns a request header by its name or NULL if there is no such header
     * Typical request headers are: Accept, Accept-Charset, Accept-Encoding,
     * Accept-Language, Connection, Host, Keep-Alive, Referer, User-Agent
     *
     * @param   string name Header
     * @param   mixed default default NULL the default value if header is non-existant
     * @return  string Header value
     */
    public function getHeader($name, $default= NULL) {
      return $this->wrapped->getHeader($name, $default);
    }

    /**
     * Returns the request method.
     *
     * @return  string
     */
    public function getMethod() {
      return $this->wrapped->getMethod();
    }
    
    /**
     * Returns the query string from its environment variable 
     * QUERY_STRING, decoding it if necessary.
     *
     * @return  string
     */
    public function getQueryString() {
      return $this->wrapped->getQueryString();
    }
    
  }
?>
