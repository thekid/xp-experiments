<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'xp.compiler.Syntax',
    'io.File',
    'io.streams.FileInputStream'
  );

  /**
   * Dumps abstract syntax tree (AST)
   *
   * @purpose  Utility
   */
  class DumpAst extends Command {
    protected
      $file     = NULL,
      $syntax   = NULL;

    /**
     * Set file to parse
     *
     * @param   string in
     */
    #[@arg(position= 0)]
    public function setIn($in) {
      $this->file= new File($in);
      if (!$this->file->exists()) {
        throw new FileNotFoundException($in);
      }
      $this->syntax= Syntax::forName($this->file->getExtension());
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      try {
        $ast= $this->syntax->parse(new FileInputStream($this->file), $this->file->getURI());
      } catch (ParseException $e) {
        $this->err->writeLinef(
          '*** Parse error: %s', 
          $e->getCause()->compoundMessage()
        );
        return;
      }

      $this->out->writeLine($ast);
    }
  }
?>
