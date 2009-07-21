<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  uses(
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.ClassPathScanner'
  );

  /**-
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·completion·Nedit extends Object {
    public
      #[@InputStream]
      $inputStream= NULL,

      #[@Cursor]
      $cursor= NULL;

    /**
     * Constructor
     *
     */
    public function __construct() {
      create(new xp·ide·ClassPathScanner())->fromCwd();
    }

    /**
     * output all suggestions
     *
     * @param   string[] suggestions
     */
    #[@complete]
    public function complete() {
      $buffer= 0 == $this->cursor->getPosition() ? '' : $this->inputStream->read($this->cursor->getPosition());
      
      $searchword= '';
      $replacepos= 0;
      for ($i= strlen($buffer) - 1; $i >= 0; $i--) {
        if (!$this->isClassChar($buffer{$i})) break;
        $replacepos= $i;
        $searchword= $buffer{$i}.$searchword;
      }
      while ($c= $this->inputStream->read(1)) {
        if (!$this->isClassChar($c)) break;
        $searchword.= $c;
      }
      $this->inputStream->close();
      
      $suggestions= create(new xp·ide·completion·PackageClassCompleter(
        new xp·ide·completion·UncompletePackageClass($searchword)
      ))->suggest();
      if (0 == count($suggestions)) return 1;

      Console::$out->writeLine($replacepos);
      Console::$out->writeLine(strlen($searchword));
      Console::$out->writeLine(count($suggestions));
      Console::$out->write(implode("\n", $suggestions));
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
      if (96 < ord(strToLower($c)) && ord(strToLower($c)) < 122) return TRUE;
      if (47 < ord($c) && ord($c) < 58) return TRUE;
      return FALSE;
    }
    
  }
?>
