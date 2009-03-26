<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.File',
    'io.streams.FileInputStream',
    'text.StreamTokenizer',
    'directives.Instruction'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      oel
   * @purpose  Utility
   */
  class Assemble extends Command {
    protected $file= NULL;
    
    const INSTRUCTION = 0;
    const ARGUMENTS   = 1;

    /**
     * Set file to parse
     *
     * @param   string name
     */
    #[@arg(position= 0)]
    public function setFile($name) {
      $this->stream= new FileInputStream(new File($name));
    }
    
    /**
     * Destructor
     *
     */
    public function __destruct() {
      $this->stream->close();
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $st= new StreamTokenizer($this->stream, " \n", TRUE);
      $op= oel_new_op_array();
      $state= self::INSTRUCTION;
      $instructions= XPClass::forName('directives.Instruction');

      $this->out->writeLine('===> Parsing');
      while ($st->hasMoreTokens()) {
        $t= $st->nextToken();
        switch ($state) {
          case self::INSTRUCTION:
            if ("\n" === $t) {
              $this->err->writeLine();
            } else if (' ' === $t) {
              // Ignore
            } else {
              try {
                $instruction= Enum::valueOf($instructions, $t);
              } catch (IllegalArgumentException $e) {
                $this->err->writeLine('*** Cannot handle "'.$t.'" instruction');
                $instruction= Instruction::$noop;
              }
              $state= self::ARGUMENTS;
              $args= array();
            }
            break;
          
          case self::ARGUMENTS:
            if ("\n" === $t) {
              $this->err->writeLine('* ', $instruction, '->(', implode(', ', array_map(array('xp', 'stringOf'), $args)), ')');
              $instruction->emit($op, $args);
              $state= self::INSTRUCTION;
            } else if (' ' === $t) {
              // Ignore
            } else if ("'" === $t{0}) {
              $args[]= substr($t, 1, -1);
            } else if ('$' === $t{0}) {
              $args[]= substr($t, 1);
            } else {
              $args[]= (int)$t;
            }
            break;
        }
      }
      
      oel_finalize($op);
      $this->out->writeLine('===> Executing');
      oel_execute($op);
    }
  }
?>
