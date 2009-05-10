<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node');

  /**
   * Represents an array access operator
   *
   */
  class ArrayAccessNode extends xp·compiler·ast·Node {
    public $offset= NULL;
    
    /**
     * Constructor
     *
     * @param   xp.compiler.ast.Node offset
     */
    public function __construct(xp·compiler·ast·Node $offset= NULL) {
      $this->offset= $offset;
    }
    
    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      return '['.($this->offset ? $this->offset->hashCode() : '').']';
    }
  }
?>
