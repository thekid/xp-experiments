<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.cmd.Command', 'io.File', 'text.diff.Difference');

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
     * @throws  io.FileNotFoundException
     */
    #[@arg(position= 0)]
    public function setFrom($from) {
      $this->from= new File($from);
      if (!$this->from->exists()) {
        throw new FileNotFoundException('File '.$from.' does not exist');
      }
    }

    /**
     * Set to filename
     *
     * @param   string to
     * @throws  io.FileNotFoundException
     */
    #[@arg(position= 1)]
    public function setTo($to) {
      $this->to= new File($to);
      if (!$this->to->exists()) {
        throw new FileNotFoundException('File '.$to.' does not exist');
      }
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
      $this->out->writeLine('- ', $this->from->getURI());
      $this->out->writeLine('+ ', $this->to->getURI());
      
      $this->emitter->emit(Difference::between(
        file($this->from->getURI(), FILE_IGNORE_NEW_LINES), 
        file($this->to->getURI(), FILE_IGNORE_NEW_LINES)
      ));
    }
  }
?>
