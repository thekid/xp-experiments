<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node', 'xp.compiler.ast.ParseTree');

  /**
   * (Insert class' description here)
   *
   * @see      xp://xp.compiler.ast.Node
   */
  abstract class Emitter extends Object {
    
    /**
     * (Insert method's description here)
     *
     * @param   xp.compiler.ast.ParseTree tree
     * @return  
     */
    public abstract function emit(ParseTree $tree);
  }
?>
