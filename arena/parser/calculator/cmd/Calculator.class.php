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
