<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.TypeMemberNode');

  /**
   * Abstract base class for all routines
   *
   * @see   xp://xp.compiler.ast.MethodNode
   * @see   xp://xp.compiler.ast.ConstructorNode
   * @see   xp://xp.compiler.ast.OperatorNode
   */
  abstract class RoutineNode extends TypeMemberNode {
    public $comment= NULL;
    
  }
?>
