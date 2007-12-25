<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.quantum.TopURIMatchesFilter');

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
    public function nameToRegex() {
      $ds= $this->directorySeparator;
      $qds= preg_quote($this->directorySeparator, '#');
      
      // Normalize pattern - replace \ with /
      $regex= str_replace('\\', '/', $this->name);
      
      // From the ant manual:
      // if a pattern ends with / or \, then ** is appended. 
      // For example, mypackage/test/ is interpreted as if it 
      // were mypackage/test/**.
      $regex= preg_replace('#([/\\\\])$#', '$1**', $regex);
      
      // Escape dots
      $regex= str_replace('.', '\\.', $regex);

      // Transform single * to [^/]* (may match anything but another directory)
      $regex= preg_replace('#(^|([^*]))\\*([^*]|$)#', '$1[^/]*$3', $regex);
      
      // Transform ** to .* (may match anything, any directory depth)
      // If ** is followed by a /, remove it, because it ** should match any depth, also
      // depth 0 - but then there is no / at the start of the path
      $regex= str_replace('**/', '.*', $regex);
      $regex= str_replace('**', '.*', $regex);
      
      // Convert directory-separator, if needed
      $regex= str_replace('/', $qds, $regex);

      // Add delimiter and escape delimiter if already contained
      $regex= '#^'.str_replace('#', '\\#', $regex).'$#';
      
      
      return $regex;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toFilter($base) {
      return new TopURIMatchesFilter($this->nameToRegex(), $base);
    }
  }
?>
