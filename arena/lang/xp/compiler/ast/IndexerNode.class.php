<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents an indexer property
   *
   * <code>
   *   class T {
   *     private string[] $elements = [];
   *
   *     public string this[int $offset] {
   *       get   { return $this.elements[$offset]; }
   *       set   { $this.elements[$offset]= $value; }
   *       isset { return isset($this.elements[$offset]); }
   *       unset { unset($this.elements[$offset]); }
   *     }
   *   }
   * 
   *   $t= new T();
   *   $t[0]= 'Hello';            // Executes set-block
   *   if (isset($t[0])) {        // Executes isset-block
   *     $hello= $t[0];           // Executes get-block
   *     unset($t[0]);            // Executes unset-block
   *   }
   * </code>
   *
   * @see   xp://xp.compiler.ast.PropertyNode
   */
  class IndexerNode extends xp�compiler�ast�Node {

  }
?>
