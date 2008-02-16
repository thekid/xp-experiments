<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.File',
    'io.FileUtil',
    'util.cmd.Command',
    'net.xp_framework.quantum.QuantProject'
  );

  /**
   * Runs a Quantum project
   *
   * @see      xp://net.xp_framework.quantum.QuantProject
   * @purpose  Command
   */
  class Quantum extends Command {
    public
      $project  = NULL;
    
    protected
      $dump     = FALSE;

    /**
     * Set buildfile
     *
     * @param   string file default NULL
     */
    #[@arg(short= 'f')]
    public function setBuildfile($file= NULL) {
      if (NULL === $file) $file= 'build.xml';
      $this->project= QuantProject::fromString(
        FileUtil::getContents(new File($file)),
        realpath($file)
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   string args
     */
    #[@args(select= '[0..]')]
    public function setArgs($args) {
      $this->args= $args;
    }

    /**
     * Enable debug / dump mode
     * 
     */
    #[@arg(short= 'd', name= 'dump')]
    public function setDump() {
      $this->dump= TRUE;    
    }
    
    /**
     * Run method
     *
     */
    public function run() {
      if ($this->dump) {
        $this->out->writeLine($this->project->toString());
        return 0;
      }
      
      return $this->project->run(
        $this->out,
        $this->err,
        $this->args
      );
    }
  }
?>
