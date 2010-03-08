<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'scriptlet.Request',
    'scriptlet.xml.XMLScriptletURL'
  );
  
  /**
   * Wraps XML request
   *
   * The request URI shall look like this without session:
   * <pre>http://foo.bar/xml/pr.de_DE/static?__page=home<pre>
   * and like this with session:
   * <pre>http://foo.bar/xml/pr.de_DE.psessionid=cb7978876218bb7/static?__page=home<pre>
   *
   * The conforming rewrite rule for apache looks like this (one line, wrapped with _
   * for readability):
   *
   * <pre>
   * RewriteRule ^/xml /index.php [PT]
   * </pre>
   * 
   * Make sure you have a directory index file or another RewriteRule to redirect
   * to http://foo.bar/xml/pr.de_DE/static?
   *
   * @see      xp://scriptlet.HttpScriptletRequest
   * @purpose  Scriptlet request wrapper
   */
  class XMLScriptletRequest extends Object implements Request {
    public
      $product      = '',
      $stateName    = '',
      $language     = '',
      $page         = '',
      $sessionId    = '';

    protected
      $request      = NULL;

    public function __construct(Request $request) {
      $this->request= $request;
    }

    /**
     * Sets request's URL
     *
     * @param   scriptlet.xml.XMLScriptletURL url
     */
    public function setURL(HttpScriptletURL $url) {
      if (!$url instanceof XMLScriptletURL) throw new IllegalArgumentException(
        __METHOD__.' expects instanceof scriptlet.xml.XMLScriptletURL, '.xp::typeof($url).' given.'
      );

      $url->setDefaultProduct($this->getDefaultProduct());
      $url->setDefaultLanguage($this->getDefaultLanguage());
      $url->setDefaultStateName($this->getDefaultStateName());
      $url->setDefaultPage($this->getDefaultPage());

      // Check cookies for session id
      $this->setSessionId($this->hasCookie('psessionid')
        ? $this->getCookie('psessionid')->getValue()
        : $url->getSessionId()
      );

      // Overwrite page with __page parameter if given
      if ($this->hasParam('__page')) $url->setPage($this->getParam('__page'));

      $this->setProduct($url->getProduct());
      $this->setLanguage($url->getLanguage());
      $this->setStateName($url->getStateName());
      $this->setPage($url->getPage());

      $this->request->setURL($url);
    }
    
    /**
     * Sets request's URI
     *
     * @param   peer.URL uri
     */
    #[@deprecated]
    public function setURI($uri) {
      $this->setURL(new XMLScriptletURL($uri->getURL()));
    }
    
    /**
     * Set Page
     *
     * @param   string page
     */
    public function setPage($page) {
      $this->page= $page;
    }

    /**
     * Get Page
     *
     * @return  string
     */
    public function getPage() {
      return $this->page;
    }

    /**
     * Gets default page (defaults to DEF_PAGE environment variable, if not
     * set default to "home")
     *
     * @return  string page
     */
    public function getDefaultPage() {
      return $this->getEnvValue('PAGE', $this->getEnvValue('DEF_PAGE', 'home'));
    }

    /**
     * Gets state
     *
     * @return  string stateName
     */
    public function getStateName() {
      return $this->stateName;
    }

    /**
     * Gets default state (defaults to DEF_STATE environment variable, if not
     * set default to "static")
     *
     * @return  string stateName
     */
    public function getDefaultStateName() {
      return $this->getEnvValue('STATE', $this->getEnvValue('DEF_STATE', 'static'));
    }

    /**
     * Sets state
     *
     * @param   string stateName
     */
    public function setStateName($stateName) {
      $this->stateName= $stateName;
    }
    
    /**
     * Gets product
     *
     * @return  string product
     */
    public function getProduct() {
      return $this->product;
    }

    /**
     * Gets default product
     *
     * @return  string product
     */
    public function getDefaultProduct() {
      return $this->getEnvValue('PRODUCT', $this->getEnvValue('DEF_PROD'));
    }

    /**
     * Sets product
     *
     * @param   string product
     */
    public function setProduct($product) {
      $this->product= $product;
    }

    /**
     * Gets language
     *
     * @return  string language
     */
    public function getLanguage() {
      return $this->language;
    }

    /**
     * Gets default language (defaults to DEF_LANG environment variable, if not
     * set default to "en_US")
     *
     * @return  string language
     */
    public function getDefaultLanguage() {
      return $this->getEnvValue('LANGUAGE', $this->getEnvValue('DEF_LANG', 'en_US'));
    }

    /**
     * Sets Language
     *
     * @param   string language
     */
    public function setLanguage($language) {
      $this->language= $language;
    }
    
    /**
     * Sets session id
     *
     * @param   string session
     */
    public function setSessionId($session) {
      $this->sessionId= $session;
    }

    /**
     * Get session's Id. This overwrites the parent's implementation 
     * of fetching the id from the request parameters. XMLScriptlets 
     * need to have the session id passed through the request URL or
     * cookie.
     *
     * @return  string session id
     */
    public function getSessionId() {
      return $this->sessionId;
    }

    public function initialize() { return $this->request->initialize(); }
    public function getSession() { return $this->request->getSession(); }
    public function hasSession() { return $this->request->hasSession(); }
    public function setSession($s) { return $this->request->setSession($s); }
    public function getEnvValue($name, $default= NULL) {  return $this->request->getEnvValue($name, $default); }
    public function putEnvValue($key, $value) { return $this->request->putEnvValue($key, $value); }
    public function getCookies() { return $this->request->getCookies(); }
    public function hasCookie($name) { return $this->request->hasCookie($name); }
    public function getCookie($name, $default= NULL) { return $this->request->getCookie($name, $default); }
    public function getHeader($name, $default= NULL) { return $this->request->getHeader($name, $default); }
    public function getParam($name, $default= NULL) { return $this->request->getParam($name, $default); }
    public function hasParam($name) { return $this->request->hasParam($name); }
    public function setParam($name, $value) { return $this->request->setParam($name, $value); }
    // public function setURL(HttpScriptletURL $url) {}
    // public function setURI($uri) {}
    public function getURI() { return $this->request->getURI(); }
    public function getURL() { return $this->request->getURL(); }
    // public function setSessionId($sessionId) { return $this->request->setSessionId($sessionId); }
    // public function getSessionId() { return $this->request->getSessionId(); }
    public function setParams($params) { return $this->request->setParams($params); }
    public function getHeaders() { return $this->request->getHeaders(); }
    public function setHeaders($headers) { return $this->request->setHeaders($headers); }
    public function addHeader($name, $value) { return $this->request->addHeader($name, $value); }
    public function getParams() { return $this->request->getParams(); }
    public function setData($data) { return $this->request->setData($data); }
    public function getData() { return $this->request->getData(); }
    public function getQueryString() { return $this->request->getQueryString(); }
    public function getContentType() { return $this->request->getContentType(); }
    public function isMultiPart() { return $this->request->isMultiPart(); }
    public function setMethod($method) { return $this->request->setMethod($method); }
    public function getMethod() { return $this->request->getMethod(); }
  }
?>
