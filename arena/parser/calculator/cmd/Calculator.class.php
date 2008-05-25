<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'math.Lexer',
    'math.Parser'
  );

  /**
   * Calculator
   *
   * Expression syntax:
   * <pre>
   *   expression :=
   *       expression * expression    // Multiplication
   *     | expression + expression    // Addition
   *     | expression - expression    // Subtraction
   *     | expression : expression    // Division
   *     | expression % expression    // Modulo
   *     | expression ^ expression    // Power
   *     | expression!                // Factorial
   *     | expression²                // Square
   *     | expression³                // Cube
   *     | ( expression )
   *     | number
   *     | constant
   *     | function ( expression [, expression, [...]] )
   *
   *   number :=
   *       integer
   *     | float
   *
   *   constant :=
   *       PI
   *     | E
   *     | EULER
   *
   *   function :=
   *       abs
   *     | acos
   *     | asin
   *     | atan
   *     | avg
   *     | call
   *     | ceil
   *     | cos
   *     | cosh
   *     | count
   *     | exp
   *     | fac
   *     | floor
   *     | ln
   *     | log
   *     | log10
   *     | max
   *     | median
   *     | min
   *     | nthrt
   *     | round
   *     | sin
   *     | sinh
   *     | sqrt
   *     | sum
   *     | tan
   *     | tanh
   * </pre>
   * 
   * Precedence rules are followed.
   *
   * @see      xp://math.Parser
   * @purpose  Parser demo
   */
  class Calculator extends Command {
    protected $expr= NULL;
    protected $verbose= FALSE;

    /**
     * Set expression to evaluate
     *
     */
    #[@arg(position= 0)]
    public function setExpression($expr) {
      $this->expr= $expr;
    }

    /**
     * Set whether to show the parsed expression before evaluating it
     *
     */
    #[@arg]
    public function setVerbose() {
      $this->verbose= TRUE;
    }


    /**
     * Main runner method
     *
     */
    public function run() {
      $expr= create(new math·Parser())->parse(new math·Lexer($this->expr));
      $this->verbose && $this->out->write($expr, '= ');
      $this->out->writeLine($expr->evaluate());
    }
  }
?>
