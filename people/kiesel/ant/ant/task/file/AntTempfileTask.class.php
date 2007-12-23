<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'ant.task.AntTask',
    'io.Folder'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class AntTempfileTask extends AntTask {
    public
      $property = NULL,
      $destdir  = NULL,
      $prefix   = NULL,
      $suffix   = NULL;
      
    #[@xmlmapping(element= '@destdir')]
    public function setDestDir($dir) {
      $this->destdir= $dir;
    }
    
    #[@xmlmapping(element= '@property')]
    public function setProperty($p) {
      $this->property= $p;
    }
    
    #[@xmlmapping(element= '@prefix')]
    public function setPrefix($p) {
      $this->prefix= $p;
    }
    
    #[@xmlmapping(element= '@suffix')]
    public function setSuffix($s) {
      $this->suffix= $s;
    }
    
    protected function getDestDir($env) {
      if (NULL === $this->destdir) return System::tempDir();
      return $env->localUri($env->substitute($this->destdir));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function execute(AntEnvironment $env) {
      $tempfile= tempname($this->getDestDir($env), $this->prefix.uniqid((double)microtime()));
      $env->put($this->property, $tempfile);
    }
  }
?>
