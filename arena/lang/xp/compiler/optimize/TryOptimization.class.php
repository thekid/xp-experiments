<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses(
    'xp.compiler.ast.TryNode',
    'xp.compiler.ast.StatementsNode',
    'xp.compiler.optimize.Optimization'
  );

  /**
   * Optimizes try / catch blocks
   *
   * @test     xp://tests.optimization.TryOptimizationTest
   */
  class TryOptimization extends Object implements Optimization {
    
    /**
     * Return node this optimization works on
     *
     * @return  lang.XPClass<? extends xp.compiler.ast.Node>
     */
    public function node() {
      return XPClass::forName('xp.compiler.ast.TryNode');
    }
    
    /**
     * Optimize a given node
     *
     * @param   xp.compiler.ast.Node in
     * @param   xp.compiler.optimize.Optimizations optimizations
     * @param   xp.compiler.ast.Node optimized
     */
    public function optimize(xp·compiler·ast·Node $in, Optimizations $optimizations) {
      $try= cast($in, 'xp.compiler.ast.TryNode');
      
      // try { ..[1].. } catch (... $e) { throw $e; } => [1]
      if (
        1 === sizeof($try->handling) && 
        $try->handling[0] instanceof CatchNode &&
        1 === sizeof($try->handling[0]->statements) &&
        $try->handling[0]->statements[0] instanceof ThrowNode &&
        $try->handling[0]->variable === $try->handling[0]->statements[0]->expression->name
      ) {
        return new StatementsNode($try->statements);
      }

      return $in;
    }
  }
?>
