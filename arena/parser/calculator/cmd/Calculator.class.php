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

    /**
     * Test
     *
     */
    #[@arg(position= 0)]
    public function setExpression($expr) {
      $this->expr= $expr;
    }


    /**
     * Main runner method
     *
     */
    public function run() {
      $expr= create(new math·Parser())->parse(new math·Lexer($this->expr));
      $this->out->write($expr, '= ');
      $this->out->writeLine($expr->evaluate());
    }
  }
?>
