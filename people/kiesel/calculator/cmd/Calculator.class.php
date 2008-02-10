<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'util.cmd.Command',
    'calc.ExpressionParser',
    'calc.Lexer'
  );

  /**
   * Calculate an expression
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class Calculator extends Command {
    protected
      $expression   = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@arg(position= 0)]
    public function setExpr($expr) {
      $this->expression= $expr;
    }
        
    /**
     * Main runner method
     *
     */
    public function run() {
      $this->out->writeLine('===> Evaluating: '.$this->expression);
      
      $parser= new ExpressionParser();
      $this->out->writeLine('===> Result: '.
        $parser->parse(
          new calc·Lexer($this->expression, '<cmdline>')
        )->evaluate()
      );
    }
  }
?>
