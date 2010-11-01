<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SvnLogEntry extends Object {
    protected
      $revision = NULL,
      $author   = NULL,
      $date     = NULL,
      $paths    = NULL,
      $message  = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@revision')]
    public function setRevision($r) {
      $this->revision= $r;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getRevision() {
      return $this->revision;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'author')]
    public function setAuthor($a) {
      $this->author= $a;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getAuthor() {
      return $this->author;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'msg')]
    public function setMessage($m) {
      $this->message= $m;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getMessage() {
      return $this->message;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'paths', class= 'name.kiesel.rss.svn.SvnLogPaths')]
    public function setPaths($p) {
      $this->paths= $p;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getPaths() {
      return $this->paths;
    }    
    
        
    
        
  }
?>
