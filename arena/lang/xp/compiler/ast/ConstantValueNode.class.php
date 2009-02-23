<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents a constant value
   *
   */
  abstract class ConstantValueNode extends xp·compiler·ast·Node {
    public $value = NULL;
  }
?>
