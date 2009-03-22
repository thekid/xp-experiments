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
   * Emits code
   *
   * @purpose  Utility
   */
  class Emit extends Command {
    protected
      $in       = NULL,
      $emitter  = NULL,
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
     * Sets emitter (default: "oel")
     *
     * @param   string emitter
     */
    #[@arg]
    public function setEmitter($emitter= 'oel') {
      $this->emitter= Package::forName('xp.compiler.emit')
        ->getPackage($emitter)
        ->loadClass('Emitter')
        ->newInstance()
      ;
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

      try {
        $file= $this->emitter->emit($ast);
      } catch (Throwable $t) {
        $this->err->writeLine('*** ', $t);
        return;
      }
      $this->out->writeLine('===> ', $this->emitter->getClassName(), ' wrote ', $file);
    }
  }
?>
