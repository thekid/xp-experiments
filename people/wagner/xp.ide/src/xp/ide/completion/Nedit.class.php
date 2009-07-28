<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  uses(
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.completion.PackageClassCompleter',
    'xp.ide.ClassPathScanner',
    'xp.ide.text.StreamWorker'
  );

  /**
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
      $searchText= create(new xp·ide·text·StreamWorker($this->inputStream, $this->cursor))->grepClassName();
      $suggestions= create(new xp·ide·completion·PackageClassCompleter(
        new xp·ide·completion·UncompletePackageClass($searchText->getText())
      ))->suggest();

      Console::$out->writeLine($searchText->getPosition());
      Console::$out->writeLine(strlen($searchText->getText()));
      Console::$out->writeLine(count($suggestions));
      Console::$out->write(implode("\n", $suggestions));
      return 0;
    }

  }
?>
