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
     * Adds all optimization implementations inside a given package
     *
     * @param   lang.reflect.Package package
     */
    public function addAll(Package $package) {
      foreach ($package->getClasses() as $class) {
        if (
          $class->isInterface() || 
          MODIFIER_PUBLIC != $class->getModifiers() || 
          !$class->isSubclassOf('xp.compiler.optimize.Optimization')
        ) continue;
        $this->add($class->newInstance());
      }
    }
    
    /**
     * Add an optimization implementation
     *
     * @param   xp.compiler.optimize.Optimization impl
     */
    public function add(Optimization $impl) {
      $this->impl[$impl->node()]= $impl;
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
    
    /**
     * Creates a string representation of this object
     *
     * @return  string
     */
    public function toString() {
      $s= $this->getClassName().'('.$this->impl->size().")@{\n";
      foreach ($this->impl->keys() as $key) {
        $s.= sprintf("  [%-20s] %s\n", $key->getSimpleName(), $this->impl->get($key)->getClassName());
      }
      return $s.'}';
    }
  }
?>
