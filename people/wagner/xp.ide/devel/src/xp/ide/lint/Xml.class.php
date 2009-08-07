<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.lint';

  uses(
    'lang.Process',
    'xp.ide.lint.ILanguage',
    'xp.ide.lint.Error'
  );

  /**
   * check xml syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Xml extends Object implements xp·ide·lint·ILanguage {

    /**
     * check source code
     *
     * @param   io.streams.InputStream
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(InputStream $stream) {
      $errors= array();
      $p= new Process('xmllint', array('-noout', '-'));
      $in= $p->getInputStream();
      while ($stream->available()) $in->write($stream->read());
      $in->close();

      $out= $p->getErrorStream();
      while (!$out->eof()) {
        if (!preg_match('#^.+:\s*(\d+)\s*:\s*(.+)$#', $out->readLine(), $match)) continue;
        $e= $errors[]= new xp·ide·lint·Error($match[1], 0, $match[2]);

        if ($out->eof()) break;
        $out->readLine();
        if ($out->eof() || !preg_match('#^(\s+\^).*$#', $out->readLine(), $match)) break;
        $e->setColumn(strlen($match[1]) - 1);
      }
      return $errors;
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
