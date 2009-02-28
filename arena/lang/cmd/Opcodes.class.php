<?php
/* This file is part of the XP framework
 *
 * $Id$
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
   * Dumps opcodes
   *
   * @ext      oel
   * @see      xp://xp.compiler.Parser
   * @purpose  Utility
   */
  class Opcodes extends Command {
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
     * Returns a string representation of an oel znode object
     *
     * @param   php.OelZnode op
     * @return  string
     */
    protected function stringOf(OelZnode $z) {
      return substr(get_class($z), strlen('OelZnode'));
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $ast= create(new Parser())->parse(new xp·compiler·Lexer(
        FileUtil::getContents($this->in),
        $this->in->getURI()
      ));

      $class= new XPClass(create(new xp·compiler·emit·oel·Emitter())->emit($ast));
      foreach ($class->getMethods() as $method) {
        if (!$class->equals($method->getDeclaringClass())) continue;

        $this->out->writeLine('== ', $method, '()');
        foreach (oel_get_op_array(array($class->getName(), $method->getName())) as $opLine) {
          // var_dump($opLine);
          $this->out->writeLinef(
            '@%3d: <%3d> %-24s %3s (%-12s, %-12s) -> %s',
            $opLine->lineno,
            $opLine->opcode->op,
            $opLine->opcode->mne,
            $opLine->extended_value ? '*'.$opLine->extended_value : '',
            $this->stringOf($opLine->op1),
            $this->stringOf($opLine->op2),
            $this->stringOf($opLine->result)
          );
        }
      }
    }
  }
?>
