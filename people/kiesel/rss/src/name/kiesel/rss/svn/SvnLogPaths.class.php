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
  class SvnLogPaths extends Object {
    protected
      $paths  = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct() {
      $this->paths= create('new util.collections.Vector<name.kiesel.rss.svn.SvnLogPath>()');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'path', class= 'name.kiesel.rss.svn.SvnLogPath')]
    public function addPath($path) {
      $this->paths[]= $path;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function pathCount() {
      return $this->paths->size();
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function pathAt($offset) {
      return $this->paths[$offset];
    }
  }
?>
