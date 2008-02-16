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
  class QuantTarget extends Object {
    public
      $name     = '',
      $depends  = array(),
      $tasks    = array();
    
    public static $packageMap= array(
      'mkdir'           => 'file',
      'copy'            => 'file',
      'touch'           => 'file',
      'delete'          => 'file',
      'tempfile'        => 'file',
      'move'            => 'file',
      'get'             => 'file',
      'echo'            => 'misc',
      'tstamp'          => 'misc',
      'jar'             => 'archive',
      'zip'             => 'archive',
      'xar'             => 'archive',
      'unzip'           => 'archive',
      'unxar'           => 'archive',
      'property'        => 'property',
      'basename'        => 'property',
      'dirname'         => 'property',
      'echoproperties'  => 'property'
    );
    
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
    public function getName() {
      return $this->name;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@depends')]
    public function setDepends($depends) {
      $this->depends= explode(',', $depends);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '*', factory= 'taskFromNode')]
    public function addTask($task) {
      $this->tasks[]= $task;
    }    
    
    public function taskFromNode($name) {
      $classname= sprintf('net.xp_framework.quantum.task.%sQuant%sTask', 
        (isset(self::$packageMap[$name]) ? self::$packageMap[$name].'.' : ''),
        ucfirst($name)
      );
      
      // HACK: if a tasks class does not exist, use the default
      try {
        return XPClass::forName($classname)->getName();
      } catch (ClassNotFoundException $e) {
        return 'net.xp_framework.quantum.task.QuantUnknownTask';
      }
    }
    
    /**
     * Check whether this target needs to be run
     *
     * @return  bool
     */
    protected function needsToRun() {
      // TBI
      return TRUE;
    }    
    
    /**
     * Run this target
     *
     * @param   net.xp_framework.quantum.QuantProject project  
     * @param   net.xp_framework.quantum.QuantEnvironment env  
     */
    public function run(QuantProject $project, QuantEnvironment $env) {
    
      if (!$this->needsToRun()) return;
    
      // Check dependencies
      foreach ($this->depends as $target) {
        $project->runTarget($target);
      }
      
      // Let task allow to do pre-execution checks
      foreach ($this->tasks as $task) {
        $task->setUp();
      }
    
      $env->out->writeLine('===> Running '.$this->name);
      foreach ($this->tasks as $task) {
        $task->run($env);
      }
    }
    
    /**
     * Creates a string representation
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'@('.$this->hashCode()."){\n";
      $s.= '  `- name: '.$this->name."\n";
      $s.= '  `- depends: '.implode(', ', $this->depends)."\n";
      $s.= '  `- ['.sizeof($this->tasks)."] tasks\n";
      return $s.'}';
    }        
  }
?>
