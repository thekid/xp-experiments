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
      $errorLine= 0,
      $errorText= '';

    /**
     * check source code
     *
     * @param   string source
     */
    #[@check]
    public function test($source) {
      $p= new Process('php', array('-l'));
      $in= $p->getInputStream();
      $in->write($source);
      $in->close();

      $out= $p->getOutputStream();
      while (!$out->eof()) {
        if (!preg_match('#^(.*) in - on line (\d+)$#', $out->readLine(), $match)) continue;
        $this->errorLine= $match[2];
        $this->errorText= $match[1];
      }
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
