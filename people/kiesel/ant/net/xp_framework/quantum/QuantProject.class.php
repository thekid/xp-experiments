<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'net.xp_framework.quantum.QuantEnvironment',
    'xml.meta.Unmarshaller'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantProject extends Object {
    public
      $filename     = NULL,
      $name         = NULL,
      $basedir      = '.',
      $description  = NULL,
      $default      = NULL,
      $paths        = array(),
      $properties   = array(),
      $targets      = array(),
      $imports      = array();
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public static function fromString($xml, $filename) {
      $project= Unmarshaller::unmarshal($xml, 'net.xp_framework.quantum.QuantProject');
      $project->filename= $filename;
      return $project;
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
    #[@xmlmapping(element= 'basedir')]
    public function setBasedir($basedir) {
      $this->basedir= $basedir;
    }
    
    /**
     * Set description
     *
     * @param   string desc
     */
    #[@xmlmapping(element= '@description|description')]
    public function setDescription($desc) {
      $this->description= trim($desc);
    }    
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'property', class= 'net.xp_framework.quantum.task.property.QuantPropertyTask')]
    public function addProperty($property) {
      $this->properties[]= $property;
    }
    
    /**
     * Add a path
     *
     * @param   net.xp_framework.quantum.QuantPath path
     */
    #[@xmlmapping(element= 'path', class= 'net.xp_framework.quantum.QuantPath')]
    public function addPath($path) {
      $this->paths[$path->getId()]= $path;
    }

    /**
     * Add a target
     *
     * @param   net.xp_framework.quantum.QuantTarget target
     */
    #[@xmlmapping(element= 'target', class= 'net.xp_framework.quantum.QuantTarget')]
    public function addTarget($target) {
      if (isset($this->targets[$target->getName()])) {
        throw new IllegalArgumentException('Target "'.$target->getName().'" is duplicate.');
      }
      
      $this->targets[$target->getName()]= $target;
    }
    
    /**
     * Adds another buildfile to import
     *
     * @param   net.xp_framework.quantum.QuantImport import
     */
    #[@xmlmapping(element= 'import', class= 'net.xp_framework.quantum.QuantImport')]
    public function importBuildfile($import) {
      $this->imports[]= $import;
    }
    
    /**
     * Sets default target
     *
     * @param   string default
     */
    #[@xmlmapping(element= '@default')]
    public function setDefault($default) {
      $this->default= $default;
    }
    
    /**
     * Runs a single target
     *
     * @param   string name
     * @throws  lang.IllegalArgumentException in case the target does not exist
     */
    public function runTarget($name) {
      if (!isset($this->targets[$name])) {
        throw new IllegalArgumentException('Target "'.$name.'" does not exist.');
      }
      $this->targets[$name]->run($this, $this->environment);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @param 
     * @param   mixed[] arguments
     * @throws  lang.IllegalArgumentException
     */
    public function run($out, $err, $arguments) {
      if (sizeof($arguments) == 0) $arguments= array($this->default);
      
      // Resolve imports
      if (sizeof($this->imports)) {
        $properties= $this->properties;
        $this->properties= array();

        foreach ($this->imports as $import) {
          $project= $import->resolve(dirname($this->filename));
          if ($project instanceof self) {

            foreach ($project->targets as $name => $target) {
              if (!isset($this->targets[$name])) $this->targets[$name]= $target;
            }
            
            foreach ($project->paths as $name => $target) {
              if (!isset($this->paths[$name])) $this->paths[$name]= $target;
            }

            $this->properties= array_merge($this->properties, $project->properties);
            foreach ($project->properties as $p) $this->properties[]= $p;
          }
        }
        
        $this->properties= array_merge((array)$this->properties, (array)$properties);
      }
      
      $target= array_shift($arguments);
      if (!isset($this->targets[$target])) {
        throw new IllegalArgumentException('Target ['.$target.'] does not exist.');
      }
      
      // Setup environment
      $this->environment= new QuantEnvironment($out, $err);
      foreach ($this->properties as $p) { $p->run($this->environment); }      
      $this->environment->setPaths($this->paths);
      
      $this->runTarget($target);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      $s= $this->getClassName().rtrim(' '.$this->name.' ').'@('.$this->hashCode()."){\n";
      $s.= '  `- default: '.$this->default."\n";
      $s.= '  `- description: '.$this->description."\n";
      $s.= "\n";
      foreach ($this->properties as $p) {
        $s.= $p->toString()."\n";
      }
      
      foreach ($this->targets as $t) {
        $s.= $t->toString()."\n";
      }
      
      return $s.'}';
    }
  }
?>
