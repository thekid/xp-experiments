<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'io.collections.query.FQLLexer',
    'io.collections.query.FQLParser'
  );

  /**
   * Compiles a file system query
   *
   */
  class Compile extends Command {
    protected $fql= NULL;

    /**
     * Sets query
     *
     * @param   string fql
     */
    #[@arg(position= 0)]
    public function setFQL($fql) {
      $this->fql= $fql;
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $this->out->writeLine($this->fql);
      $parser= new FQLParser();
      try {
        $iterator= $parser->parse(new FQLLexer($this->fql, '(command line argument)'));
        $this->out->writeLine($iterator);
        return 0;
      } catch (ParseException $e) {
        $this->err->writeLine($e->getCause());
        return 1;
      }
    }
  }
?>
