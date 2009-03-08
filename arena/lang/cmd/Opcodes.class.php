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
      $class= NULL;
      
    /**
     * Set input
     *
     * @param   string in
     */
    #[@arg(position= 0)]
    public function setIn($in) {
      if (strstr($in, '.xp')) {
        $this->class= new XPClass(create(new xp·compiler·emit·oel·Emitter())->emit(create(new Parser())->parse(new xp·compiler·Lexer(
          FileUtil::getContents(new File($in)),
          $in
        ))));
      } else if (strstr($in, xp::CLASS_FILE_EXT)) {
        $file= new File($in);
        $uri= $file->getURI();
        $path= dirname($uri);
        $paths= array_flip(array_map('realpath', xp::$registry['classpath']));
        $class= NULL;
        while (FALSE !== ($pos= strrpos($path, DIRECTORY_SEPARATOR))) { 
          if (isset($paths[$path])) {
            $this->class= XPClass::forName(strtr(substr($uri, strlen($path)+ 1, -10), DIRECTORY_SEPARATOR, '.'));
            return;
          }

          $path= substr($path, 0, $pos); 
        }
        throw new IllegalArgumentException('Cannot determine class from "'.$in.'"');
      } else {
        $this->class= XPClass::forName($in);
      }
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
      foreach ($this->class->getMethods() as $method) {
        if (!$this->class->equals($method->getDeclaringClass())) continue;

        $this->out->writeLine('== ', $method, '()');
        foreach (oel_export_op_array(array($this->class->getName(), $method->getName())) as $opLine) {
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
