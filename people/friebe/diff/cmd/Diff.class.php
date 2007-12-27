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
      $verbose = FALSE;
    
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
     */
    #[@arg]
    public function setVerbose() {
      $this->verbose= TRUE;
    }
    
    /**
     * Run this command
     *
     */
    public function run() {
      $this->out->writeLine('- ', $this->from->getURI());
      $this->out->writeLine('+ ', $this->to->getURI());
      
      foreach (Difference::between(file($this->from->getURI()), file($this->to->getURI()), $this->verbose) as $op) {
        if ($op instanceof Copy) {
          $this->out->write(' ', $op->text);
        } else if ($op instanceof Change) {
          $this->out->write('-', $op->text);
          $this->out->write('+', $op->newText);
        } else if ($op instanceof Deletion) {
          $this->out->write('<', $op->text);
        } else if ($op instanceof Insertion) {
          $this->out->write('>', $op->text);
        }
      }
    }
  }
?>
