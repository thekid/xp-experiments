<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node');

  /**
   * Static initializer
   *
   */
  class StaticInitializerNode extends xp·compiler·ast·Node {
    public $statements;
    
    /**
     * Creates a new static initializer node
     *
     * @param   xp.compiler.ast.Node[] statements
     */
    public function __construct($statements) {
      $this->statements= $statements;
    }
  }
?>
