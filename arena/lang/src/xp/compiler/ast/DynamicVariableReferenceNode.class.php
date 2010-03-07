<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node');

  /**
   * Dynamic variable reference
   *
   * Example
   * ~~~~~~~
   * <code>
   *   $this->$name;
   *   $this->{$name};
   *   $this->{substr($name, 0, -5)};
   * </code>
   *
   * Note
   * ~~~~
   * This is only available in PHP syntax!
   *
   */
  class DynamicVariableReferenceNode extends xp·compiler·ast·Node {
    public $expression = NULL;
    
    /**
     * Creates a new dynamic variable reference
     *
     * @param  xp.compiler.ast.Node expression
     */
    public function __construct(xp·compiler·ast·Node $expression) {
      $this->expression= $expression;
    }
  }
?>
