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
      $valid      = NULL;

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
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlfactory(element= '@lang')]    
    public function getLanguageCode() {
      return $this->code;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlfactory(element= '@timestamp')]
    public function getTimestampForXml() {
      return $this->timestamp->toString();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlfactory(element= '@author')]
    public function getAuthor() {
      return $this->author;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlfactory(element= '.')]
    public function getSnippet() {
      return $this->snippet;
    }    
    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      $s= $this->getClassName().'@('.$this->hashCode().') {'.PHP_EOL;
      $s.= sprintf("  [%s] => (author= %s, timestamp= %s, valid= %s)\n",
        $this->code,
        $this->author,
        $this->timestamp->toString(),
        $this->valid
      );
      $s.= "    '".$this->snippet."'\n";
      return $s.'  }'.PHP_EOL;
    }    
  }
?>
