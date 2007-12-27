<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('io.streams.StringWriter');

  /**
   * Emits a diff
   *
   * @purpose  Abstract base class
   */
  abstract class AbstractDiffEmitter extends Object {

    /**
     * Constructor
     *
     * @param   io.streams.StringWriter out
     */
    public function __construct(StringWriter $out) {
      $this->out= $out;
    }
    
    /**
     * Emit the difference
     *
     * @param   text.diff.AbstractOperation[] diff
     */
    public abstract function emit(array $diff);
    
  }
?>
