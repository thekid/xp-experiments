<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents a map literal
   *
   */
  class MapNode extends xp·compiler·ast·Node {
    public $type;
    public $elements;
  }
?>
