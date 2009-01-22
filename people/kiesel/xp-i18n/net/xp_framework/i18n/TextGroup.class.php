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
  class TextGroup extends Object {
    protected
      $name         = NULL,
      $description  = NULL,
      $textgroups   = array(),
      $snippets     = array();
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'xp:description')]
    public function setDescription($d) {
      $this->description= $d;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@name')]
    public function setName($n) {
      $this->name= $n;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'xp:textgroup', class= 'net.xp_framework.i18n.TextGroup')]
    public function addTextGroup(self $tg) {
      $this->textgroups[]= $tg;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'xp:text', class= 'net.xp_framework.i18n.TextSnippet')]
    public function addTextSnippet(TextSnippet $ts) {
      $this->snippets[]= $ts;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      $s= $this->getClassName().'@('.$this->hashCode().') {'.PHP_EOL;
      $s.= sprintf("name= '%s'\n", $this->name);
      $s.= sprintf("description= '%s'\n", $this->description);
      $s.= "textgroups= [\n";
      
      foreach ($this->textgroups as $tg) {
        $s.= $tg->toString();
      }
      
      foreach ($this->snippets as $ts) {
        $s.= $ts->toString();
      }
      
      return $s.PHP_EOL;
    }
  }
?>
