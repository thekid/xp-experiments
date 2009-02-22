<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents a variable
   *
   */
  class VariableNode extends xp·compiler·ast·Node {
    public
      $name    = '',
      $chained = NULL;
    
    /**
     * Constructor
     *
     * @param   string name
     * @param   xp.compiler.ast.Node chained
     */
    public function __construct($name= '', xp·compiler·ast·Node $chained= NULL) {
      $this->name= $name;
      $this->chained= $chained;
    }
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return 'xp.var:'.$this->name;
    }
  }
?>
