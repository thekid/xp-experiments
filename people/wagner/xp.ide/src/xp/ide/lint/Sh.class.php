<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.lint';
  
  uses(
    'io.File',
    'lang.System'
  );
 
  /**
   * check sh shell script syntax
   *
   * @purpose  IDE
   */
  class xp·ide·lint·Sh extends Object {
    private
      $errorLine= 0,
      $errorText= '';

    /**
     * check source code
     *
     * @param   string ource
     */
    #[@check]
    public function checkSource($source) {
      $f= new File(tempnam(System::getProperty('os.tempdir'), 'xil'));
      $f->open(FILE_MODE_WRITE);
      $f->write($source);
      $f->close();
      
      $p= new Process('sh', array('-n', $f->getUri()));

      $out= $p->getErrorStream();
      while (!$out->eof()) {
        if (!preg_match('#^.+:\s*(\d+)\s*:\s*(.+)$#', $out->readLine(), $match)) continue;
        $this->errorLine= $match[1];
        $this->errorText= $match[2];
      }
      $f->unlink();
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
