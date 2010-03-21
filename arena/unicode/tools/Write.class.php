<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses('util.cmd.Command');

  /**
   * Writes a text to the console
   *
   */
  class Write extends Command {
    protected $text= NULL;

    /**
     * Sets text to write
     *
     * @param   string text
     */
    #[@arg(position= 0)]
    public function setText($text= 'Hello World') {
      $this->text= $text;
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $this->out->writeLine('Raw    : ', $this->text);
      $this->out->writeLine('String : ', new String($this->text));
      $this->err->writeLine('Bytes  : ', new Bytes($this->text));
    }
  }
?>
