<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node');
  
  /**
   * Represents a chain
   *
   * Examples:
   * <code>
   *   $a.property.value;
   *   $a.method().value;
   *   $a[0];
   *   func().length;
   *   new Date().toString();
   *   $class.getMethods()[0];
   * </code>
   * ...or any combination of these.
   */
  class ChainNode extends xp·compiler·ast·Node {
    public $elements= array();
    
    /**
     * Constructor
     *
     * @param   xp.compiler.ast.Node[] elements
     */
    public function __construct($elements= array()) {
      $this->elements= $elements;
    }

    /**
     * Returns a hashcode
     *
     * @return  string
     */
    public function hashCode() {
      $s= '';
      foreach ($this->elements as $node) {
        $s.= '.'.$node->hashCode();
      }
      return $s;
    }
  }
?>
