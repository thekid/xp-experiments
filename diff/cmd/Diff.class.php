<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'util.cmd.Command', 
    'io.File', 
    'text.diff.Difference', 
    'text.diff.source.BufferedFileSource'
  );

  /**
   * Computes the difference between two files
   *
   * @see      xp://text.diff.Difference
   * @purpose  Command
   */
  class Diff extends Command {
    protected
      $from    = NULL,
      $to      = NULL,
      $emitter = NULL;
    
    /**
     * Set from filename
     *
     * @param   string to
     */
    #[@arg(position= 0)]
    public function setFrom($from) {
      $this->from= new BufferedFileSource(new File($from));
    }

    /**
     * Set to filename
     *
     * @param   string to
     */
    #[@arg(position= 1)]
    public function setTo($to) {
      $this->to= new BufferedFileSource(new File($to));
    }
    
    /**
     * Set whether to be verbose
     *
     * @param   string name default "Verbose"
     */
    #[@arg]
    public function setEmitter($name= 'Verbose') {
      $this->emitter= Package::forName('text.diff.emit')->loadClass($name)->newInstance($this->out);
    }
    
    /**
     * Run this command
     *
     */
    public function run() {
      $this->emitter->emit(Difference::between($this->from, $this->to));
    }
  }
?>
