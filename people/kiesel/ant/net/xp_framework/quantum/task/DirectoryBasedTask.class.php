<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.task.QuantTask',
    'net.xp_framework.quantum.QuantFileset'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  abstract class DirectoryBasedTask extends QuantTask {
    public
      $fileset  = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct() {
      $this->fileset= new QuantFileset();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'include', class= 'net.xp_framework.quantum.QuantPattern')]
    public function addIncludePattern($include) {
      $this->fileset->addIncludePattern($include);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@includes')]
    public function addIncludePatternString($includes) {
      $this->fileset->addIncludePatternString($includes);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'exclude', class= 'net.xp_framework.quantum.QuantPattern')]
    public function addExcludePattern($exclude) {
      $this->fileset->addExcludePattern($exclude);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@excludes')]
    public function addExcludePatternString($excludes) {
      $this->fileset->addExcludePatternString($excludes);
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'fileset', class= 'net.xp_framework.quantum.QuantFileset')]
    public function setFileset($set) {
      $this->fileset= $set;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@dir')]
    public function setDir($dir) {
      $this->fileset->setDir($dir);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function iteratorForFileset(QuantEnvironment $env) {
      return $this->fileset->iteratorFor($env);
    }
  }
?>
