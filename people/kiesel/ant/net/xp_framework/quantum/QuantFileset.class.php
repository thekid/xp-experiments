<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.QuantPattern',
    'net.xp_framework.quantum.QuantPatternSet',
    'net.xp_framework.quantum.QuantFileIterator',
    'io.collections.FileCollection',
    'io.collections.iterate.FilteredIOCollectionIterator'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantFileset extends Object {
    public
      $dir        = NULL,
      $file       = NULL,
      $patternset = NULL;

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct() {
      $this->patternset= new QuantPatternSet();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@defaultexcludes')]
    public function setDefaultExcludes($d) {
      $this->patternset->setDefaultExcludes($d);
    }
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@dir')]
    public function setDir($dir) {
      $this->dir= $dir;
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@file')]
    public function setFile($file) {
      $this->file= $file;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'include', class= 'net.xp_framework.quantum.QuantPattern')]
    public function addIncludePattern($include) {
      $this->patternset->addIncludePattern($include);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@includes')]
    public function addIncludePatternString($includes) {
      $this->patternset->addIncludePattern($includes);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'exclude', class= 'net.xp_framework.quantum.QuantPattern')]
    public function addExcludePattern($exclude) {
      $this->patternset->addExcludePattern($exclude);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@excludes')]
    public function addExcludePatternString($excludes) {
      $this->patternset->addExcludePattern($excludes);
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'patternset', class= 'net.xp_framework.quantum.QuantPatternSet')]
    public function setPatternSet($set) {
      $this->patternset= $set;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getDir(QuantEnvironment $env) {
      return $env->localUri($env->substitute($this->dir));
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function iteratorFor(QuantEnvironment $env) {
      if (!($dir= $this->getDir($env))) {
        $dir= getcwd();
      }
      $realdir= realpath($dir);
      if (!$realdir) throw new IllegalStateException('Directory "'.$dir.'" does not exist.');
      
      return new QuantFileIterator(
        new FileCollection($realdir),
        $this->patternset->createFilter($env, $realdir),
        TRUE,
        $realdir
      );
    }
  }
?>
