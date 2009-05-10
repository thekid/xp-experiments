<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.TypeDeclarationNode');

  /**
   * Represents an interface declaration
   *
   */
  class InterfaceNode extends TypeDeclarationNode {
    public $parents= NULL;
  }
?>
