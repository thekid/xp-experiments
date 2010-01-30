<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node');

  /**
   * Abstract base class for all routines
   *
   * @see   xp://xp.compiler.ast.MethodNode
   * @see   xp://xp.compiler.ast.ConstructorNode
   * @see   xp://xp.compiler.ast.OperatorNode
   */
  abstract class RoutineNode extends xp·compiler·ast·Node {
    public $comment= NULL;
    
    /**
     * Returns this routine's name
     *
     * @return  string
     */
    public abstract function getName();
  }
?>
