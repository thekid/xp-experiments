<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'text.diff.emit';
  
  uses('text.diff.AbstractDiffEmitter');

  /**
   * Verbose emitter. Shows all content, using "-" and "+" for changes,
   * ">" for insertions and "<" for deletions.
   *
   * @see      xp://text.diff.AbstractDiffEmitter
   * @purpose  Emitter implementation
   */
  class text·diff·emit·Verbose extends AbstractDiffEmitter {
    
    /**
     * Emit the difference
     *
     * @param   text.diff.Difference diff
     * @throws  lang.IllegalStateException in case the diff array contains an unknown element
     */
    public function emit(Difference $diff) {
      $this->out->writeLine('- ', $diff->from());
      $this->out->writeLine('+ ', $diff->to());

      foreach ($diff->operations() as $op) {
        if ($op instanceof Copy) {
          $this->out->writeLine(' ', $op->text);
        } else if ($op instanceof Change) {
          $this->out->writeLine('-', $op->text);
          $this->out->writeLine('+', $op->newText);
        } else if ($op instanceof Deletion) {
          $this->out->writeLine('<', $op->text);
        } else if ($op instanceof Insertion) {
          $this->out->writeLine('>', $op->text);
        } else {
          throw new IllegalStateException('Unknown operation '.xp::typeOf($op));
        }
      }
    }
  }
?>
