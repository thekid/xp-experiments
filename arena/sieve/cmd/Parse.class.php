<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'util.cmd.Command',
    'peer.sieve.SieveParser',
    'peer.sieve.Lexer',
    'io.File',
    'io.FileUtil'
  );

  /**
   * (Insert class' description here)
   *
   * @see      reference
   * @purpose  purpose
   */
  class Parse extends Command {

    /**
     * Set file to parse
     *
     * @param   string f
     */
    #[@arg(position= 0)]
    public function setFile($f) {
      $this->f= new File($f);
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      try {
        $this->out->writeLine(create(new SieveParser())->parse(new peer·sieve·Lexer(FileUtil::getContents($this->f), $this->f->getURI())));
      } catch (ParseException $e) {
        $e->getCause()->printStackTrace();
        return 1;
      }
      return 0;
    }
  }
?>
