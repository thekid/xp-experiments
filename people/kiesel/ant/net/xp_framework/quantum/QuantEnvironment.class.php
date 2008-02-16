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
      $paths              = array(),
      $defaultExcludes    = array(),
      $directorySeparator = DIRECTORY_SEPARATOR,
      $pathSeparator      = PATH_SEPARATOR;

    /**
     * (Insert method's description here)
     *
     * @param   
     * @param  
     * @param  
     */
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
     * Retrieve current path separator
     *
     * @return  string
     */
    public function pathSeparator() {
      return $this->pathSeparator;
    }
    
    /**
     * Put a property
     *
     * @param   string key
     * @param   string value
     * @throws  lang.IllegalArgumentException if the property has already been declared
     */
    public function put($key, $value) {
      if (isset($this->hashmap[$key]))
        throw new IllegalArgumentException('Property ['.$key.'] already declared.');
      
      $this->hashmap[$key]= $value;
    }
    
    /**
     * Get a property
     *
     * @param   string key
     * @return  string
     * @throws  lang.IllegalArgumentException if the property does not exist
     */
    public function get($key) {
      if (!isset($this->hashmap[$key]))
        throw new IllegalArgumentException('Property ['.$key.'] does not exist.');
        
      return $this->hashmap[$key];
    }

    /**
     * Get a path
     *
     * @param   string id
     * @return  string
     * @throws  lang.IllegalArgumentException if the path does not exist
     */
    public function getPath($id) {
      if (!isset($this->paths[$id]))
        throw new IllegalArgumentException('Path ['.$id.'] does not exist.');
        
      return $this->paths[$id];
    }
    
    /**
     * Set paths (and resolve them)
     *
     * @param   array<string, net.xp_framework.quantum.QuantPath> paths
     */
    public function setPaths($paths) {
      foreach ($paths as $id => $path) {
        $this->paths[$id]= array();
        foreach ($path->getFilesets() as $set) {
          foreach ($set->iteratorFor($this) as $file) {
            $this->paths[$id][]= $set->getDir($this).$this->directorySeparator.$file->relativePath();
          }
        }
      }
    }
    
    /**
     * Reset pointer of property hash
     *
     */
    public function resetPointer() {
      reset($this->hashmap);
    }
    
    /**
     * Get next property
     *
     * @return  string[2]
     */
    public function nextProperty() {
      if (NULL === key($this->hashmap)) return NULL;
      $retval= array(key($this->hashmap), current($this->hashmap));
      next($this->hashmap);
      return $retval;
    }
          
    /**
     * (Insert method's description here)
     *
     * @param   string key
     * @return  bool
     */
    public function exists($key) {
      return isset($this->hashmap[$key]);
    }
    
    /**
     * Substitute variables inside a string
     *
     * @param   string
     * @return  string
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
      return strtr($uri, '\\', '/');
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
