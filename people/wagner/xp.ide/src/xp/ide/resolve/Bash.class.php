<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.resolve';
  
  uses(
    'util.cmd.Console',
    'xp.ide.resolve.Resolver'
  );

  /**
   * Find a class in the source tree
   *
   * @purpose  IDE
   */
  class xp·ide·resolve·Bash extends xp·ide·resolve·Resolver {

    /**
     * print the result
     *
     * @param   string[] sources
     * @return  string
     */
    #[@output]
    public function transform(array $sources) {
      Console::$out->write(implode(' ', $sources));
    }

    /**
     * resolve a xar class
     *
     * @param   lang.archive.ArchiveClassLoader cp
     * @param   string name
     * @return  string
     */
    protected function resolveAcl(ArchiveClassLoader $cp, $name) {
      Console::$err->writeLine(sprintf('Class "%s" is part of an archive: %s', $name, xp::stringOf($cp)));
    }
  }
?>
