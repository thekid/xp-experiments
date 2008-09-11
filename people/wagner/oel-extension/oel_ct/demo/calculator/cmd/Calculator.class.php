<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'oel.Lexer',
    'oel.Parser',
    'oel.InstructionTree',
    'oel.ExecuteVisitor',
    'oel.DebugVisitor'
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
   *     | ( expression )
   *     | number
   *
   *   number :=
   *       integer
   *     | float
   *     | pi
   *     | e
   *     | euler
   * </pre>
   * 
   * Precedence rules are followed.
   *
   * @see      xp://oel.Parser
   * @purpose  OEL demo
   */
  class Calculator extends Command {
    protected $expr= NULL;

    /**
     * Set expression to evaluate
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
      $parser= new oel·Parser();
      $instructionTree= $parser->parse(new oel·Lexer($this->expr));

      $this->out->write($this->expr, '= ');
      $this->out->writeLine($instructionTree->accept(new oel·ExecuteVisitor(oel_new_op_array())));
    }
  }
?>
