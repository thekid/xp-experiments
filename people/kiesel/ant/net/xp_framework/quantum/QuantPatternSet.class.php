<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.collections.iterate.AllOfFilter',
    'io.collections.iterate.AnyOfFilter',
    'io.collections.iterate.NegationOfFilter'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantPatternSet extends Object {
    public
      $id               = NULL,
      $includes         = array(),
      $excludes         = array(),
      $defaultExcludes  = TRUE;
    
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
    #[@xmlmapping(element= '@refid')]
    public function setRefId($refid) {
      $this->refid= $refid;
    }    

    /**
     * Set DefaultExcludes
     *
     * @access  public
     * @param   bool defaultExcludes
     */
    #[@xmlmapping(element= '@defaultexcludes')]
    function setDefaultExcludes($defaultExcludes) {
      $this->defaultExcludes= ('yes' == $defaultExcludes);
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'include', class= 'net.xp_framework.quantum.QuantPattern')]
    public function addIncludePattern($pattern) {
      if (is_string($pattern)) {
        $pattern= new QuantPattern($pattern);
      }
      
      if (!$pattern instanceof QuantPattern) 
        throw new IllegalArgumentException('Expecting QuantPattern or string');
      
      $this->includes[]= $pattern;
    }
  
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'exclude', class= 'net.xp_framework.quantum.QuantPattern')]
    public function addExcludePattern($pattern) {
      if (is_string($pattern)) {
        $pattern= new QuantPattern($pattern);
      }
      
      if (!$pattern instanceof QuantPattern) {
        throw new IllegalArgumentException('Expecting QuantPattern or string');
      }
      
      $this->excludes[]= $pattern;
    }

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function createFilter(QuantEnvironment $env, $basedir) {
      
      $inc= $exc= array();
      foreach ($this->includes as $include) {
        if ($include->applies($env)) {
          $inc[]= $include->toFilter($basedir);
        }
      }
      
      foreach ($this->excludes as $exclude) {
        if ($exclude->applies($env)) {
          $exc[]= $exclude->toFilter($basedir);
        }
      }
      
      if ($this->defaultExcludes) foreach ($env->getDefaultExcludes() as $exclude) {
        if ($exclude->applies($env)) {
          $exc[]= $exclude->toFilter($basedir);
        }
      }
      
      if (!sizeof($inc))
        throw new IllegalStateException('No positive filter has been given.');
      
      $filter= array(new AnyOfFilter($inc));
      if (sizeof($exc)) {
        $filter[]= new NegationOfFilter(new AnyOfFilter($exc));
      }
      
      return new AllOfFilter($filter);
    }
    
    public function evaluatePatternOn(QuantEnvironment $env, $name) {
      $positive= FALSE;
      foreach ($this->includes as $include) {
        if ($include->applies($env)) {
          if ($include->getMatcher()->matches($name)) {
            $positive= TRUE;
            break;
          }
        }
      }
      
      if (!$positive) return FALSE;
      
      foreach ($this->excludes as $exclude) {
        if ($exclude->applies($env)) {
          if ($exclude->getMatcher()->matches($name)) {
            return FALSE;
          }
        }
      }
      
      return TRUE;
    }
    
    /**
     * Retrieve string representation
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'@('.$this->hashCode().") {\n";
      $s.= "  includes= {\n    ";
      foreach ($this->includes as $i) {
        $s.= implode("\n    ", explode("\n", $i->toString()))."\n";
      }
      $s.= "  }\n  excludes= {\n    ";
      foreach ($this->excludes as $e) {
        $s.= implode("\n    ", explode("\n", $e->toString()))."\n";
      }
      
      return $s.'  }';
    }
  }
?>
