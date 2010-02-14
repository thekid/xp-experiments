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
   *     public int length {
   *       get { return $this._length; }
   *       set { $this._length= $value; }
   *     }
   *   }
   * </code>
   */
  class PropertyNode extends xp·compiler·ast·Node {
    
  }
?>
