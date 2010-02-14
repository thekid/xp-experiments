<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents an array literal
   *
   */
  class ArrayNode extends xp·compiler·ast·Node {
    public $type;
    public $values;
  }
?>
