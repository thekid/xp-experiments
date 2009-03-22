<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
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
      $in       = NULL,
      $syntax   = NULL;

    /**
     * Returns a parser object
     *
     * @param   lang.reflect.Package p
     * @return  text.parser.generic.AbstractParser
     */
    protected function parser(Package $p) {
      return $p->loadClass('Parser')->newInstance();
    }

    /**
     * Returns a lexer object
     *
     * @param   lang.reflect.Package p
     * @param   io.File in
     * @return  text.parser.generic.AbstractLexer
     */
    protected function lexer(Package $p, File $in) {
      return $p->loadClass('Lexer')->newInstance(new FileInputStream($in), $in->getURI());
    }
      
    /**
     * Set file to parse
     *
     * @param   string in
     */
    #[@arg(position= 0)]
    public function setIn($in) {
      $this->in= new File($in);
      $this->syntax= Package::forName('xp.compiler.syntax')->getPackage($this->in->getExtension());
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      try {
        $ast= create($this->parser($this->syntax))->parse($this->lexer($this->syntax, $this->in));
      } catch (ClassNotFoundException $e) {
        $this->err->writeLinef(
          '*** Cannot parse "%s" files: %s', 
          $this->in->getExtension(),
          $e->compoundMessage()
        );
        return;
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
