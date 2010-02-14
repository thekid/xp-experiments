<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents a property
   *
   * <code>
   *   class T {
   *     private int $_length= 0;
   *
   *     public int length {
   *       get { return $this._length; }
   *       set { $this._length= $value; }
   *     }
   *   }
   * 
   *   $t= new T();
   *   $length= $t.length;    // Executes get-block
   *   $t.length= 1;          // Executes set-block
   * </code>
   *
   * @see   xp://xp.compiler.ast.IndexerNode
   */
  class PropertyNode extends xp�compiler�ast�Node {
    
  }
?>
