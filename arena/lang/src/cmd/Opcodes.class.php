<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses('util.cmd.Command', 'io.File');

  /**
   * Dumps opcodes
   *
   * @see      xp://xp.compiler.Parser
   * @purpose  Utility
   */
  class Opcodes extends Command {
    protected
      $class   = NULL,
      $verbose = FALSE;
    
    /**
     * Determine class object from a given file by searching the class path.
     *
     * @param   io.File file
     * @return  lang.XPClass
     */
    protected function classFrom(File $file) {
      $uri= $file->getURI();
      $path= dirname($uri);
      $paths= array_flip(array_map('realpath', xp::$registry['classpath']));
      $class= NULL;
      while (FALSE !== ($pos= strrpos($path, DIRECTORY_SEPARATOR))) { 
        if (isset($paths[$path])) {
          return XPClass::forName(strtr(substr($uri, strlen($path)+ 1, -10), DIRECTORY_SEPARATOR, '.'));
        }

        $path= substr($path, 0, $pos); 
      }
      throw new IllegalArgumentException('Cannot determine class from "'.$in.'"');
    }
    
    /**
     * Set input
     *
     * @param   string in
     */
    #[@arg(position= 0)]
    public function setIn($in) {
      if (strstr($in, xp::CLASS_FILE_EXT)) {
        $this->class= $this->classFrom(new File($in));
      } else {
        $this->class= XPClass::forName($in);
      }
    }
    
    /**
     * Set whether to be verbose
     *
     */
    #[@arg]
    public function setVerbose() {
      $this->verbose= TRUE;
    }
    
    /**
     * Dumps a string representation of an op array
     *
     * @param   var ops
     */
    private function dumpOps($ops, $indent= '  ') {
      foreach (oel_export_op_array($ops) as $opline) {
        switch ($opline->opcode->mne) {
          case 'FETCH_CLASS': $details= array($opline->op2->value); break;
          case 'DECLARE_CLASS': $details= array($opline->op2->value); break;
          case 'DECLARE_INHERITED_CLASS': $details= array($opline->op2->value); break;
          case 'INIT_STATIC_METHOD_CALL': $details= array($opline->op2->value); break;
          case 'INIT_METHOD_CALL': $details= array($opline->op2->value); break;
          case 'INIT_FCALL_BY_NAME': $details= array($opline->op2->value); break;
          case 'SEND_VAL': $details= array($opline->extended_value, $opline->op1->value); break;
          case 'FETCH_OBJ_R': $details= array($opline->op2->value); break;
          case 'FETCH_DIM_R': $details= array($opline->op2->value); break;
          default: $details= NULL; // var_dump($opline);
        }
        $this->out->writeLinef(
          '%s@%-3d: <%03d> %s %s', 
          $indent,
          $opline->lineno,
          $opline->opcode->op,
          $opline->opcode->mne,
          $details ? '['.str_replace("\n", "\n".$indent, implode(', ', array_map(array('xp', 'stringOf'), $details))).']' : ''
        );
        $this->verbose && $this->out->writeLine($indent, xp::stringOf($opline, $indent));
      }
    }
    
    /**
     * Main runner method
     *
     */
    public function run() {
      foreach ($this->class->getMethods() as $method) {
        if (!$this->class->equals($method->getDeclaringClass())) continue;

        $this->out->writeLine('== ', $method, '()');
        $this->dumpOps(array($this->class->getSimpleName(), $method->getName()));
      }
    }
  }
?>
