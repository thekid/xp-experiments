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
  abstract class QuantTask extends Object {
    protected
      $id       = NULL,
      $taskname = NULL,
      $desc     = NULL;
    
    private
      $env      = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@id')]
    public function setId($id) {
      $this->id= $id;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@taskname')]
    public function setTaskName($taskname) {
      $this->taskname= $taskname;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= '@description')]
    public function setDescription($desc) {
      $this->desc= $desc;
    }
    
    protected function env() {
      if (!$this->env instanceof QuantEnvironment)
        throw new IllegalStateException('No environment access possible at this stage');
      
      return $this->env;
    }
    
    protected function valueOf($value) {
      return $this->env()->substitute($value);
    }
    
    protected function uriOf($value) {
      return $this->env()->localUri($this->env()->substitute($value));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function needsToRun($env) {
      return TRUE;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    abstract protected function execute();
    
    /**
     * Perform pre-execution checks
     *
     */
    public function setup() {
      // This is the place to check for proper configuration. If
      // there is something mis-configured throw an Exception
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    final public function run(QuantEnvironment $env) {
      $this->env= $env;
      
      if ($this->needsToRun()) {
        $this->execute($env);
      }
      
      $this->env= NULL;
    }
  }
?>
