<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Represents an XML namespace
   *
   */
  class XMLNamespace extends Object {
    protected $prefix= NULL;
    protected $uri= NULL;
    
    public static $XML= NULL;
    public static $NONE= NULL;
    
    static function __static() {
      self::$NONE= new self(NULL, '');
      self::$XML= new self('xml', 'http://www.w3.org/XML/1998/namespace');
    }
    
    /**
     * Constructor
     *
     * @param   string prefix
     * @param   string uri
     */
    public function __construct($prefix, $uri) {
      $this->prefix= $prefix;
      $this->uri= $uri;
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function getPrefix() {
      return $this->prefix;
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  string
     */
    public function getUri() {
      return $this->uri;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   string name
     * @return  string
     */
    public function qualify($name) {
      return ($this->prefix ? $this->prefix.':' : '').$name;
    }
  }
?>
