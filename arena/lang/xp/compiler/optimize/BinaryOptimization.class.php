<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.compiler.ast.StringNode',
    'xp.compiler.ast.IntegerNode',
    'xp.compiler.ast.DecimalNode',
    'xp.compiler.ast.NumberNode',
    'xp.compiler.ast.NaturalNode',
    'xp.compiler.ast.ConstantValueNode',
    'xp.compiler.ast.BinaryOpNode',
    'xp.compiler.ast.Resolveable'
  );

  /**
   * Optimizes binary operations
   *
   * @test     xp://tests.optimization.BinaryOptimizationTest
   */
  class BinaryOptimization extends Object {
    protected static $optimizable= array(
      '~'   => 'concat',
      '-'   => 'subtract',
      '+'   => 'add',
      '*'   => 'multiply',
      '/'   => 'divide',
    );      

    
    /**
     * Evaluate concatenation
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalConcat(ConstantValueNode $l, ConstantValueNode $r) {
      return new StringNode(array('value' => $l->resolve().$r->resolve()));
    }
    
    /**
     * Evaluate addition
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalAdd(ConstantValueNode $l, ConstantValueNode $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode(array('value' => $l->resolve() + $r->resolve()));
      } else if (($l instanceof DecimalNode && $r instanceof NumberNode) || ($l instanceof NumberNode && $r instanceof DecimalNode)) {
        return new DecimalNode(array('value' => $l->resolve() + $r->resolve()));
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate subtraction
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalSubtract(ConstantValueNode $l, ConstantValueNode $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode(array('value' => $l->resolve() - $r->resolve()));
      } else if (($l instanceof DecimalNode && $r instanceof NumberNode) || ($l instanceof NumberNode && $r instanceof DecimalNode)) {
        return new DecimalNode(array('value' => $l->resolve() - $r->resolve()));
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate multiplication
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalMultiply(ConstantValueNode $l, ConstantValueNode $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode(array('value' => $l->resolve() * $r->resolve()));
      } else if (($l instanceof DecimalNode && $r instanceof NumberNode) || ($l instanceof NumberNode && $r instanceof DecimalNode)) {
        return new DecimalNode(array('value' => $l->resolve() * $r->resolve()));
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate division
     *
     * @param   xp.compiler.ast.ConstantValueNode l
     * @param   xp.compiler.ast.ConstantValueNode r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalDivide(ConstantValueNode $l, ConstantValueNode $r) {
      if ($l instanceof NumberNode && $r instanceof NumberNode) {
        return new DecimalNode(array('value' => $l->resolve() / $r->resolve()));
      } else {
        return NULL;  // Not optimizable
      }
    }
    
    /**
     * Optimize a given node
     *
     * @param   xp.compiler.ast.Node in
     * @param   xp.compiler.ast.Node optimized
     */
    public function optimize(xp·compiler·ast·Node $in) {
      
      // Check for optimization possibilities if left- and righthand sides can be resolved
      // FIXME: 1 + 2 + 3; will create Add(Add(Number(1), Add(Number(2)), Number(3))
      // and thus the right-hand side is not a Resolveable (but could be).
      if (isset(self::$optimizable[$in->op]) && $in->lhs instanceof Resolveable && $in->rhs instanceof Resolveable) {
        try {
          $r= call_user_func_array(array($this, 'eval'.self::$optimizable[$in->op]), array($in->lhs, $in->rhs));
        } catch (XPException $e) {
          $r= NULL;
        }
        if (NULL !== $r) return $r;
      }

      return $in;
    }
  }
?>
