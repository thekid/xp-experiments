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
    'xp.compiler.ast.Resolveable',
    'xp.compiler.ast.BinaryOpNode',
    'xp.compiler.optimize.Optimization'
  );

  /**
   * Optimizes binary operations
   *
   * @see      http://en.wikipedia.org/wiki/Constant_folding
   * @test     xp://tests.optimization.BinaryOptimizationTest
   */
  class BinaryOptimization extends Object implements Optimization {
    protected static $optimizable= array(
      '~'   => 'concat',
      '-'   => 'subtract',
      '+'   => 'add',
      '*'   => 'multiply',
      '/'   => 'divide',
      '%'   => 'modulo',
      '<<'  => 'shl',
      '>>'  => 'shr',
      '&'   => 'and',
      '|'   => 'or',
      '^'   => 'xor'
    );      
    
    /**
     * Evaluate concatenation
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalConcat(Resolveable $l, Resolveable $r) {
      return new StringNode($l->resolve().$r->resolve());
    }
    
    /**
     * Evaluate addition
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalAdd(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() + $r->resolve());
      } else if (($l instanceof DecimalNode && $r instanceof NumberNode) || ($l instanceof NumberNode && $r instanceof DecimalNode)) {
        return new DecimalNode($l->resolve() + $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate subtraction
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalSubtract(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() - $r->resolve());
      } else if (($l instanceof DecimalNode && $r instanceof NumberNode) || ($l instanceof NumberNode && $r instanceof DecimalNode)) {
        return new DecimalNode($l->resolve() - $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate multiplication
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalMultiply(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() * $r->resolve());
      } else if (($l instanceof DecimalNode && $r instanceof NumberNode) || ($l instanceof NumberNode && $r instanceof DecimalNode)) {
        return new DecimalNode($l->resolve() * $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate division
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalDivide(Resolveable $l, Resolveable $r) {
      if ($l instanceof NumberNode && $r instanceof NumberNode) {
        return new DecimalNode($l->resolve() / $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate modulo
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalModulo(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() % $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate shift right
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalShr(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() >> $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate shift left
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalShl(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() << $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate and ("&")
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalAnd(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() & $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate or ("|")
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalOr(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() | $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }

    /**
     * Evaluate xor ("^")
     *
     * @param   xp.compiler.ast.Resolveable l
     * @param   xp.compiler.ast.Resolveable r
     * @return  xp.compiler.ast.Node result
     */
    protected function evalXOr(Resolveable $l, Resolveable $r) {
      if ($l instanceof NaturalNode && $r instanceof NaturalNode) {
        return new IntegerNode($l->resolve() ^ $r->resolve());
      } else {
        return NULL;  // Not optimizable
      }
    }
    
    /**
     * Return node this optimization works on
     *
     * @return  lang.XPClass<? extends xp.compiler.ast.Node>
     */
    public function node() {
      return XPClass::forName('xp.compiler.ast.BinaryOpNode');
    }
    
    /**
     * Unwrap braced expressions
     *
     * @param   xp.compiler.ast.Node node
     * @return  xp.compiler.ast.Node node
     */
    protected function unwrap($node) {
      return $node instanceof BracedExpressionNode ? $node->expression : $node;
    }
    
    /**
     * Optimize a given node
     *
     * @param   xp.compiler.ast.Node in
     * @param   xp.compiler.optimize.Optimizations optimizations
     * @param   xp.compiler.ast.Node optimized
     */
    public function optimize(xp�compiler�ast�Node $in, Optimizations $optimizations) {
      if (isset(self::$optimizable[$in->op])) {
        $lhs= $optimizations->optimize($this->unwrap($in->lhs));
        $rhs= $optimizations->optimize($this->unwrap($in->rhs));

        if ($lhs instanceof Resolveable && $rhs instanceof Resolveable) {
          try {
            $r= call_user_func_array(array($this, 'eval'.self::$optimizable[$in->op]), array($lhs, $rhs));
          } catch (XPException $e) {
            $r= NULL;
          }
          if (NULL !== $r) return $r;
        }
      }

      return $in;
    }
  }
?>
