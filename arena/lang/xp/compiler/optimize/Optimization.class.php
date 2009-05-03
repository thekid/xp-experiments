<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.ast.Node', 'xp.compiler.optimize.Optimizations');

  /**
   * Optimizations can optimize given nodes
   *
   */
  interface Optimization {
    
    /**
     * Optimize a given node
     *
     * @param   xp.compiler.ast.Node in
     * @param   xp.compiler.optimize.Optimizations optimizations
     * @param   xp.compiler.ast.Node optimized
     */
    public function optimize(xp·compiler·ast·Node $in, Optimizations $optimizations);
  }
?>
