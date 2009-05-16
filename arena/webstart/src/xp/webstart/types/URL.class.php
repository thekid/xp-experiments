<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.webstart.types';

  /**
   * Represents an XNLP URL
   *
   */
  class xp·webstart·types·URL extends Object {
    protected $uri;

    /**
     * Constructor
     *
     * @param   string uri
     */
    public function __construct($uri= '') {
      $this->setUri($uri);
    }
    
    /**
     * Sets uri
     *
     * @param   string uri
     */
    #[@xmlmapping(element= '.')]
    public function setUri($uri) {
      $this->uri= $uri;
    }

    /**
     * Gets uri
     *
     * @return  string
     */
    public function getUri() {
      return $this->uri;
    }
    
    /**
     * Returns an absolute path
     *
     * @param   xp.webstart.types.URL other
     * @return  xp.webstart.types.URL
     */
    public function resolve(self $other) {
      if (strstr($other->uri, '://')) {
        return $other;
      } else {
        return new self(rtrim($this->uri, '/').'/'.$other->uri);
      }
    }
    
    /**
     * Creates a string representation
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->uri.'>';
    }
  }
?>
