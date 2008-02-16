<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.quantum.task.QuantTask', 'lang.Process');

  /**
   * Executes a Java class by forking the Java VM
   *
   * @see      http://ant.apache.org/manual/CoreTasks/java.html
   * @purpose  Task implementation
   */
  class QuantJavaTask extends QuantTask {
    protected
      $classpath    = NULL,
      $classpathref = NULL,
      $classname    = '';

    /**
     * Set class name
     *
     * @param   string classname
     */
    #[@xmlmapping(element= '@classname')]
    public function setClassName($classname) {
      $this->classname= $classname;
    }

    /**
     * Add an argument
     *
     * @param   string argument
     */
    #[@xmlmapping(element= 'arg/@value')]
    public function addArgument($argument) {
      $this->arguments[]= $argument;
    }

    /**
     * Set Classpath
     *
     * @param   string classpath
     */
    #[@xmlmapping(element= '@classpath')]
    public function setClasspath($classpath) {
      $this->classpath= $classpath;
    }

    /**
     * Set Classpathref
     *
     * @param   string classpathref
     */
    #[@xmlmapping(element= '@classpathref|classpath/@refid')]
    public function setClasspathref($classpathref) {
      $this->classpathref= $classpathref;
    }

    /**
     * Get Classpath
     *
     * @param   net.xp_framework.quantum.QuantEnvironment env
     * @return  string[]
     */
    public function getClasspath(QuantEnvironment $env) {
      if ($this->classpathref) {
        return $env->getPath($this->classpathref);
      }
      
      return $env->localUri($env->substitute($this->classpath));
    }

    /**
     * Execute this task
     *
     */
    public function execute() {
      $env= $this->env();
      $cmdline= array();
      if ($this->classpath || $this->classpathref) $cmdline[]= '-classpath "'.implode($env->pathSeparator(), $this->getClasspath($env)).'"';

      // Append classname and arguments
      $cmdline[]= $this->classname;
      $cmdline= array_merge($cmdline, $this->arguments);
      try {
        
        // Start java process
        $p= new Process('java', $cmdline);
        $env->out->writeLine('---> Executing '.$p->getCommandLine());
        
        // Read error output if any
        while (!$p->out->eof()) {
          $env->out->writeLine('[STDOUT:java] '.$p->out->readLine()); 
        }
        // Read error output if any
        while (!$p->err->eof()) {
          $env->err->writeLine('[STDERR:java] '.$p->err->readLine()); 
        }
        $p->close();
      } catch (IOException $e) {
        $env->err->writeLine($e->toString());
      }
    }    
  }
?>
