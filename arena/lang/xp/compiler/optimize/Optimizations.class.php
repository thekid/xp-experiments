<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.collections.HashTable', 'xp.compiler.ast.Node', 'xp.compiler.optimize.Optimization');

  /**
   * Optimizer API
   *
   */
  class Optimizations extends Object {
    protected $impl= NULL;

    /**
     * Constructor.
     *
     */
    public function __construct() {
      $this->impl= new HashTable();
    }
    
    /**
     * Add an optimization implementations for a given node class
     *
     * @param   lang.XPClass class
     * @param   xp.compiler.optimize.Optimization impl
     */
    public function add(XPClass $class, Optimization $impl) {
      $this->impl[$class]= $impl;
    }
    
    /**
     * Optimize a given node
     *
     * @param   xp.compiler.ast.Node in
     * @param   xp.compiler.ast.Node optimized
     */
    public function optimize(xp·compiler·ast·Node $in) {
      $key= $in->getClass();
      if (!$this->impl->containsKey($key)) {
        return $in;
      } else {
        return $this->impl[$key]->optimize($in, $this);
      }
    }
  }
?>
