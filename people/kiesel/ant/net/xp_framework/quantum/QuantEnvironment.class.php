<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.QuantPattern'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantEnvironment extends Object {
    public
      $in   = NULL,
      $out  = NULL,
      $err  = NULL;
      
    protected
      $hashmap            = array(),
      $defaultExcludes    = array(),
      $directorySeparator = DIRECTORY_SEPARATOR;

    public function __construct($out, $err, $ds= DIRECTORY_SEPARATOR) {
      $this->out= $out;
      $this->err= $err;
      $this->directorySeparator= $ds;
      $this->initializeDefaultExcludes();
    }
    
    public function initializeDefaultExcludes() {
      $this->defaultExcludes= array(
        '**/*~',
        '**/#*#',
        '**/.#*',
        '**/%*%',
        '**/._*',
        '**/CVS',
        '**/CVS/**',
        '**/.cvsignore',
        '**/SCCS',
        '**/SCCS/**',
        '**/vssver.scc',
        '**/.svn',
        '**/.svn/**',
        '**/.DS_Store'
      );
    }
    
    /**
     * Retrieve current directory separator
     *
     * @return  string
     */
    public function directorySeparator() {
      return $this->directorySeparator;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function put($key, $value) {
      if (isset($this->hashmap[$key]))
        throw new IllegalArgumentException('Property ['.$key.'] already declared.');
      
      $this->hashmap[$key]= $value;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function get($key) {
      if (!isset($this->hashmap[$key]))
         throw new IllegalArgumentException('Property ['.$key.'] does not exist.');
        
      return $this->hashmap[$key];
    }
    
    public function resetPointer() {
      reset($this->hashmap);
    }
    
    public function nextProperty() {
      if (NULL === key($this->hashmap)) return NULL;
      $retval= array(key($this->hashmap), current($this->hashmap));
      next($this->hashmap);
      return $retval;
    }
          
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function exists($key) {
      return isset($this->hashmap[$key]);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function substitute($string) {
      return preg_replace_callback('#\$\{([^\}]+)\}#', array($this, 'replaceCallback'), $string);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function replaceCallback($matches) {
      return $this->get($matches[1]);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function localUri($uri) {
      if ('/' == $this->directorySeparator) return $uri;
      return strtr($uri, '/', $this->directorySeparator);
    }
    
    /**
     * Create unixoid uri representation, namely use / as directory
     * separator
     *
     * @param   string $uri
     * @return  string
     */
    public function unixUri($uri) {
      return strtr($uri, '\\', $this->directorySeparator);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getDefaultExcludes() {
      $patterns= array();
      foreach ($this->defaultExcludes as $e) {
        $patterns[]= new QuantPattern($e, $this->directorySeparator());
      }
      return $patterns;
    }

    public function addDefaultExclude($e) {
      if (!in_array($e, $this->defaultExcludes)) {
        $this->defaultExcludes[]= $e;
      }
    }
    
    public function removeDefaultExclude($e) {
      $index= array_search($e, $this->defaultExcludes, TRUE);
      if (FALSE !== $index) unset($this->defaultExcludes[$index]);
    }
  }
?>
