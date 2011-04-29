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
   * Perform a file system query
   *
   */
  class Query extends Command {
    protected $iterator= NULL;

    /**
     * Sets query
     *
     * @param   string fql
     */
    #[@arg(position= 0)]
    public function setFQL($fql) {
      $parser= new FQLParser();
      try {
        $this->iterator= $parser->parse(new FQLLexer($fql, '(command line argument)'));
      } catch (ParseException $e) {
        $this->err->writeLine($e->getCause());
        throw new IllegalArgumentException('Cannot parse <'.$fql.'>');
      }
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      foreach ($this->iterator as $element) {
        $this->out->writeLine('- ', $element);
      }
    }
  }
?>
