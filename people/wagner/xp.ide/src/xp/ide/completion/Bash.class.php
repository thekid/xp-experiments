<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  uses(
    'xp.ide.completion.UncompletePackageClass',
    'xp.ide.completion.PackageClassCompleter',
    'util.cmd.Console',
    'xp.ide.ClassPathScanner'
  );

  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·completion·Bash extends Object {
    public
      #[@InputStream]
      $stream= NULL;

    /**
     * Constructor
     *
     */
    public function __construct() {
      create(new xp·ide·ClassPathScanner())->fromCwd();
    }

    /**
     * make suggestions
     *
     */
    #[@complete]
    public function suggest() {
      $input= '';
      while ($this->stream->available()) $input.= $this->stream->read();
      $this->stream->close();

      $suggestions= create(new xp·ide·completion·PackageClassCompleter(
        new xp·ide·completion·UncompletePackageClass($input)
      ))->suggest();
      Console::$out->write(implode(PHP_EOL, $suggestions));
    }
  }
?>
