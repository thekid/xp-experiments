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
  class TextSnippet extends Object {
    protected
      $name         = NULL,
      $description  = NULL,
      $translations = array();
    
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
    #[@xmlmapping(element= 'xp:translation', class= 'net.xp_framework.i18n.Translation')]
    public function addTranslation(Translation $t) {
      if (isset($this->translations[$t->getLanguageCode()]))
        throw new IllegalArgumentException('Double translation!');
      
      $this->translations[$t->getLanguageCode()]= $t;
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
      $s.= "translations [\n  ";
      
      foreach ($this->translations as $t) {
        $s.= str_replace("\n", "\n  ", $t->toString());
      }
      
      return $s.'}'.PHP_EOL;
    }    
    
  }
?>
