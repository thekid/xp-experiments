<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents a constructor
   *
   */
  class ConstructorNode extends xp·compiler·ast·Node {
    public
      $modifiers  = 0,
      $parameters = array();
    
  }
?>
