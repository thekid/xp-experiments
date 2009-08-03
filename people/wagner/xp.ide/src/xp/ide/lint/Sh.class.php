<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.lint';

  uses(
    'io.File',
    'lang.System',
    'lang.Process',
    'xp.ide.lint.ILanguage',
    'xp.ide.lint.Error'
  );

  /**
   * check sh shell script syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Sh extends Object implements xp·ide·lint·ILanguage {

    /**
     * check source code
     *
     * @param   io.streams.InputStream
     * @return xp.ide.lint.Error[]
     */
    public function checkSyntax(InputStream $stream) {
      $errors= array();
      $f= new File(tempnam(System::getProperty('os.tempdir'), 'xil'));
      $f->open(FILE_MODE_WRITE);
      while ($stream->available()) $f->write($stream->read());
      $f->close();

      $p= new Process('sh', array('-n', $f->getUri()));

      $out= $p->getErrorStream();
      while (!$out->eof()) {
        if (!preg_match('#^.+:\s*(\d+)\s*:\s*(.+)$#', $out->readLine(), $match)) continue;
        $errors[]= new xp·ide·lint·Error($match[1], 0, $match[2]);
      }
      $f->unlink();
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
