<?php
/* This file is part of the XP framework
 *
 * $Id: DumpAst.class.php 10023 2008-01-15 18:32:50Z friebe $
 */
  uses(
    'util.cmd.Command',
    'io.File',
    'io.FileUtil',
    'xp.compiler.Lexer',
    'xp.compiler.Parser',
    'xp.compiler.emit.oel.Emitter'
  );

  /**
   * Emits code
   *
   * @see      xp://xp.compiler.Parser
   * @purpose  Utility
   */
  class Emit extends Command {
    protected
      $in       = NULL,
      $emitter = NULL;
      
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
     * (Insert method's description here)
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
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@arg]
    public function setArgs($args= NULL) {
      $this->args= NULL !== $args ? explode(',', $args) : array();
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      try {
        $ast= create(new Parser())->parse(new xp·compiler·Lexer(
          FileUtil::getContents($this->in),
          $this->in->getURI()
        ));
      } catch (ParseException $e) {
        $this->err->writeLine('*** ', $e);
        return;
      }
      $class= $this->emitter->emit($ast);
      $this->out->writeLine('===> Compiled class ', $class);
      
      // {{{ Run - FIXME - this should be done somewhere else! 
      xp::gc();
      $this->out->writeLine('===> Running ', $class.'::main()');
      eval ($class.'::main($this->args);');
      // }}}
    }
  }
?>
