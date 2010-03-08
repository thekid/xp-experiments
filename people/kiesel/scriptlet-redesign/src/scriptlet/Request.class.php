<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  interface Request {
    public function initialize();
    public function getSession();
    public function hasSession();
    public function setSession($s);
    public function getEnvValue($name, $default= NULL);
    public function putEnvValue($key, $value);
    public function getCookies();
    public function hasCookie($name);
    public function getCookie($name, $default= NULL);
    public function getHeader($name, $default= NULL);
    public function getParam($name, $default= NULL);
    public function hasParam($name);
    public function setParam($name, $value);
    public function setURL(HttpScriptletURL $url);
    public function setURI($uri);
    public function getURI();
    public function getURL();
    public function setSessionId($sessionId);
    public function getSessionId();
    public function setParams($params);
    public function getHeaders();
    public function setHeaders($headers);
    public function addHeader($name, $value);
    public function getParams();
    public function setData($data);
    public function getData();
    public function getQueryString();
    public function getContentType();
    public function isMultiPart();
    public function setMethod($method);
    public function getMethod();
  }

?>