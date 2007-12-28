<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'text.diff.emit';
  
  uses('text.diff.AbstractDiffEmitter');

  /**
   * Unified emitter. 
   *
   * @see      xp://text.diff.AbstractDiffEmitter
   * @purpose  Emitter implementation
   */
  class text·diff·emit·Unified extends AbstractDiffEmitter {

    /**
     * Emit the difference
     *
     * @param   text.diff.AbstractOperation[] diff
     * @throws  lang.IllegalStateException in case the diff array contains an unknown element
     */
    public function emit(array $diff) {
      $context= 6;
      $ch= floor($context / 2);

      for ($t= 0, $f= 0, $i= 0, $s= sizeof($diff); $i < $s; $i++) {
        $t++; $f++;
        // Console::$err->writeLine('*i = ', $i, '= ', $diff[$i]);
        if ($diff[$i] instanceof Copy) continue;
        
        // Found beginning of a changeset. From the current offset, 
        // search for the next position that we find <context> consecutive
        // lines without modifications (or the end of the difference)
        for ($c= 0, $l= 0, $lt= 0, $lf= 0; $c <= $context && $l+ $i < $s; $l++) {
          $op= $diff[$l+ $i];
          if ($op instanceof Copy) {
            $c++; $lt++; $lf++;
          } else {
            $c= 0;
            $lt+= $op instanceof Change || $op instanceof Insertion;
            $lf+= $op instanceof Change || $op instanceof Deletion;
          }
        }
        
        // Print changeset introduction. This contains:
        // - The line number in <to>
        // - The number of context lines in <to>
        // - The line number in <from>
        // - The number of context lines in <from>
        $this->out->writeLinef('@@ -%d,%d +%d,%d @@', $f- $ch, $lf- 1, $t- $ch, $lt- 1);
        
        // Start from context/2 lines and print out all the information
        $o= max(0, $i - $ch);
        for ($j= 0; $j < $l; $j++) {
          $op= $diff[$j+ $o];
          if ($op instanceof Copy) {
            $this->out->writeLine(' ', $op->text);
          } else if ($op instanceof Change) {
            $this->out->writeLine('-', $op->text);
            $this->out->writeLine('+', $op->newText);
          } else if ($op instanceof Deletion) {
            $this->out->writeLine('-', $op->text);
          } else if ($op instanceof Insertion) {
            $this->out->writeLine('+', $op->text);
          } else {
            throw new IllegalStateException('Unknown operation '.xp::typeOf($op));
          }
        }

        if ($f- $ch+ 1 == 505) {
          Console::$err->writeLine('-i = ', $i, '= ', $diff[$i]);
        }

        $i+= $j;
        
        if ($f- $ch+ 1 == 505) {
          Console::$err->writeLine('+i = ', $i, '= ', $diff[$i]);
        }
        
        $t+= $lt;
        $f+= $lf;
      }
    }
  }
?>
