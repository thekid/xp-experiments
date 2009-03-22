<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'util.cmd.Command',
    'io.File',
    'io.FileUtil',
    'xp.compiler.syntax.xp.Lexer',
    'xp.compiler.syntax.xp.Parser'
  );

  /**
   * Dumps abstract syntax tree (AST)
   *
   * @see      xp://xp.compiler.Parser
   * @purpose  Utility
   */
  class DumpAst extends Command {
    protected
      $in= NULL;
      
    /**
     * Set file to parse
     *
     * @param   string in
     */
    #[@arg(position= 0)]
    public function setIn($in) {
      $this->in= new File($in);
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      try {
        $ast= create(new xp·compiler·syntax·xp·Parser())->parse(new xp·compiler·syntax·xp·Lexer(
          FileUtil::getContents($this->in),
          $this->in->getURI()
        ));
      } catch (ParseException $e) {
        $this->err->writeLine('*** Parse error: ', $e->getCause());
        return;
      }
      $this->out->writeLine($ast);
    }
  }
?>
