<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'net.xp_framework.quantum.task.DirectoryBasedTask', 
    'io.collections.iterate.CollectionFilter',
    'io.collections.iterate.NegationOfFilter',
    'io.collections.iterate.AllOfFilter',
    'lang.Process'
  );

  /**
   * Jars a set of files.
   *
   * @see      http://ant.apache.org/manual/CoreTasks/jar.html
   * @purpose  Task implementation
   */
  class QuantJarTask extends DirectoryBasedTask {
    protected
      $destfile   = '';

    /**
     * Set the JAR file to create
     *
     * @param   string destfile
     */
    #[@xmlmapping(element= '@destfile|@jarfile')]
    public function setDestfile($destfile) {
      $this->destfile= $destfile;
    }

    /**
     * Get the JAR file to create
     *
     * @param   net.xp_framework.quantum.QuantEnvironment
     * @return  string
     */
    public function getDestfile(QuantEnvironment $env) {
      return realpath($env->substitute($this->destfile));
    }

    /**
     * Set the directory from which to jar the files.
     *
     * @param   string dir
     */
    #[@xmlmapping(element= '@basedir')]
    public function setSrcdir($dir) {
      $this->fileset->setDir($dir);
    }

    /**
     * Execute this task
     *
     */
    protected function execute() {
      $env= $this->env();
      try {
        
        // Start jar process
        $p= new Process('jar', array('cf@', $this->getDestfile($env)), $this->fileset->getDir($env));
        $env->out->writeLine('---> Executing '.$p->getCommandLine());
        
        // Pass file names to STDIN of jar process
        // * Make sure we exclude directories because JAR will include
        //   their contents recursively otherwise
        // * Use forward-slashes inside JAR
        with ($it= $this->iteratorForFileset($env)); {
          $it->filter= new AllOfFilter(array(
            new NegationOfFilter(new CollectionFilter()),
            $it->filter
          ));
          while ($it->hasNext()) {
            $p->in->write($env->unixUri($it->next()->relativePath())."\n");
          }
        }
        $p->in->close();
        
        // Read error output if any
        while (!$p->err->eof()) {
          $env->err->writeLine('[STDERR:jar] '.$p->err->readLine()); 
        }
        $p->close();
      } catch (IOException $e) {
        $env->err->writeLine($e->toString());
      }
    }    
  }
?>
