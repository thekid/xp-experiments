<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'text.diff.emit';
  
  uses('text.diff.AbstractDiffEmitter');

  /**
   * Verbose emitter
   *
   * @see      xp://text.diff.AbstractDiffEmitter
   * @purpose  Emitter implementation
   */
  class text·diff·emit·Verbose extends AbstractDiffEmitter {
    
    /**
     * Emit the difference
     *
     * @param   text.diff.AbstractOperation[] diff
     * @throws  lang.IllegalStateException in case the diff array contains an unknown element
     */
    public function emit(array $diff) {
      foreach ($diff as $op) {
        if ($op instanceof Copy) {
          $this->out->write(' ', $op->text);
        } else if ($op instanceof Change) {
          $this->out->write('-', $op->text);
          $this->out->write('+', $op->newText);
        } else if ($op instanceof Deletion) {
          $this->out->write('<', $op->text);
        } else if ($op instanceof Insertion) {
          $this->out->write('>', $op->text);
        } else {
          throw new IllegalStateException('Unknown operation '.xp::typeOf($op));
        }
      }
    }
  }
?>
