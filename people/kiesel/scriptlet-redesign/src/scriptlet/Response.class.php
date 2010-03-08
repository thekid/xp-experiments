<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  interface Response {
    public function setURI($uri);
    public function sendRedirect($location);
    public function sendBasicAuthenticate($realm= '');
    public function setHeader($name, $value);
    public function setContentLength($len);
    public function setContentType($type);
    public function setCookie($cookie);
    public function setStatus($sc);
    public function headersSent();
    public function getHeader($name, $default= NULL);
    public function sendHeaders();
    public function process();
    public function sendContent();
    public function write($s);
    public function setContent($content);
    public function getContent();
  }

?>