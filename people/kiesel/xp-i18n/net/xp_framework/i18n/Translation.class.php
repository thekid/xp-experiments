<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.Date');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Translation extends Object {
    protected
      $code       = NULL,
      $timestamp  = NULL,
      $author     = NULL,
      $snippet    = NULL,
      $isValid    = NULL;

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@lang')]
    public function setLanguageCode($c) {
      $this->code= $c;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getLanguageCode() {
      return $this->code;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@timestamp')]
    public function setTimestamp($t) {
      $this->timestamp= new Date($t);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@author')]
    public function setAuthor($a) {
      $this->author= $a;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@isValid')]
    public function setValidity($v) {
      $this->isValid= $v;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '.')]
    public function setSnippet($s) {
      $this->snippet= trim($s);
    }
  }
?>
