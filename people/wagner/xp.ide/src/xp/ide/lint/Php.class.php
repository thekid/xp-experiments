<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 $package= 'xp.ide.lint';
 
  /**
   * check php syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Php extends Object {
    private
      $source= '',
      $errorLine= 0,
      $errorText= '';

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    #[@check]
    public function test() {
      $p= new Process('php', array('-l'));
      $in= $p->getInputStream();
      $in->write($this->source);
      $in->close();

      $out= $p->getOutputStream();
      while (!$out->eof()) {
        if (!preg_match('#^(.*) in - on line (\d+)$#', $out->readLine(), $match)) continue;
        $this->errorLine= $match[2];
        $this->errorText= $match[1];
      }
    }

    /**
     * Set source
     *
     * @param   string source
     */
    #[@source]
    public function setSource($source) {
      $this->source= $source;
    }

    /**
     * Get errorLine
     *
     * @return  int
     */
    #[@errorline]
    public function getErrorLine() {
      return $this->errorLine;
    }

    /**
     * Get errortext
     *
     * @return  string
     */
    #[@errortext]
    public function getErrortext() {
      return $this->errorText;
    }
  }
?>
