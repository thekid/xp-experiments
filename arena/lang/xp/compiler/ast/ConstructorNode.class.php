<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.RoutineNode');

  /**
   * Represents a constructor
   *
   */
  class ConstructorNode extends RoutineNode {
    public
      $modifiers  = 0,
      $parameters = array();
    
  }
?>
