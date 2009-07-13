<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 $package= 'xp.ide.lint';
 
  /**
   * check xml syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Xml extends Object {
    private
      $source= '',
      $errorLine= 0,
      $errorCol= 0,
      $errorText= '';

    /**
     * Main runner method
     *
     * @param   string[] args
     */
    #[@check]
    public function test() {
      $p= new Process('xmllint', array('-noout', '-'));
      $in= $p->getInputStream();
      $in->write($this->source);
      $in->close();

      $out= $p->getErrorStream();
      while (!$out->eof()) {
        if (!preg_match('#^.+:\s*(\d+)\s*:\s*(.+)$#', $out->readLine(), $match)) continue;
        $this->errorLine= $match[1];
        $this->errorText= $match[2];
        if ($out->eof()) return 0;
        $out->readLine();
        if ($out->eof() || !preg_match('#^(\s+\^).*$#', $out->readLine(), $match)) return 0;
        $this->errorCol= strlen($match[1]);
        return 0;
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
     * Get errorCol
     *
     * @return  int
     */
    #[@errorcolumn]
    public function getErrorCol() {
      return $this->errorCol;
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
