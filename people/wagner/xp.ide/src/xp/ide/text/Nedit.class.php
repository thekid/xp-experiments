<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';
  
  uses(
    'xp.ide.resolve.Nedit'
  )

  /**
   * nedit text actions
   *
   * @purpose  IDE
   */
  class xp·ide·text·Nedit extends Object {
    public
      #[@InputStream]
      $inputStream= NULL,

      #[@Cursor]
      $cursor= NULL;

    /**
     * output all suggestions
     *
     * @param   string[] suggestions
     */
    #[@action(name='grepclassfile')]
    public function grepclass() {
      $buffer= 0 == $this->cursor->getPosition() ? '' : $this->inputStream->read($this->cursor->getPosition());
      
      $searchword= '';
      $startpos= strlen($buffer);
      for ($i= $startpos - 1; $i >= 0; $i--) {
        if (!$this->isClassChar($buffer{$i})) break;
        $startpos= $i;
        $searchword= $buffer{$i}.$searchword;
      }
      while ($c= $this->inputStream->read(1)) {
        if (!$this->isClassChar($c)) break;
        $searchword.= $c;
      }
      $this->inputStream->close();

      

      Console::$out->writeLine($startpos);
      Console::$out->writeLine(strlen($searchword));
      Console::$out->writeLine($searchword);
      return 0;
    }

    /**
     * test if char is allowed in a fully qualified class name
     *
     * @param   char c
     * @return  bool
     */
    private function isClassChar($c) {
      if ($c == '.') return TRUE;
      if (96 < ord(strToLower($c)) && ord(strToLower($c)) < 123) return TRUE;
      if (47 < ord($c) && ord($c) < 58) return TRUE;
      return FALSE;
    }
    
  }
?>
