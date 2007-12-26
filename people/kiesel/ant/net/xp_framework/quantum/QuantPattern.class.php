<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.QuantPatternFilter'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantPattern extends Object {
    public
      $name   = NULL,
      $if     = NULL,
      $unless = NULL;
    
    protected
      $directorySeparator= DIRECTORY_SEPARATOR;
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($name= NULL, $ds= DIRECTORY_SEPARATOR) {
      $this->name= $name;
      $this->directorySeparator= $ds;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setDirectorySeparator($ds) {
      $this->directorySeparator= $ds;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@name')]
    public function setName($name) {
      $this->name= $name;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@if')]
    public function setIf($if) {
      $this->if= $if;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@unless')]
    public function setUnless($unless) {
      $this->unless= $unless;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function applies(QuantEnvironment $env) {
      if (NULL !== $this->if) {
        return $env->exists($this->if);
      }
      
      if (NULL !== $this->unless) {
        return !$env->exists($this->unless);
      }
      
      // Otherwise always applies
      return TRUE;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toFilter($base) {
      return new QuantPatternFilter($this->name, $base);
    }
    
    public function getMatcher() {
      return new QuantPatternMatcher($this->name);
    }
    
    /**
     * Create string representation
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'@('.$this->hashCode().") {\n";
      $s.= '  pattern= "'.$this->name.'"'."\n";
      if ($this->if) $s.= '  if= ${'.$this->if."}\n";
      if ($this->unless) $s.= '  unless= ${'.$this->unless."}\n";
      return $s. '}';  
    }
  }
?>
