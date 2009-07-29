<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.resolve';
  
  uses(
    'util.cmd.Console',
    'xp.ide.ClassPathScanner',
    'xp.ide.resolve.Resolver'
  );
  
  /**
   * Find a class in the source tree
   *
   * @purpose  IDE
   */
  class xp·ide·resolve·Nedit extends xp·ide·resolve·Resolver {
    private
      $status= 2;

    /**
     * Constructor
     *
     */
    public function __construct() {
      create(new xp·ide·ClassPathScanner())->fromCwd();
    }

    /**
     * print the result
     *
     * @param   string[] sources
     * @return  string
     */
    #[@output]
    public function transform(array $sources) {
      Console::$out->write(implode(PHP_EOL, $sources));
      return $this->result;
    }

    /**
     * resolve a file system class
     *
     * @param   lang.FileSystemClassLoader cp
     * @param   string name
     * @return  string
     */
    protected function resolveFscl(FileSystemClassLoader $cp, $name) {
      $this->status= 0;
      return parent::resolveFscl($cp, $name);
    }

    /**
     * resolve a xar class
     *
     * @param   lang.archive.ArchiveClassLoader cp
     * @param   string name
     * @return  string
     */
    protected function resolveAcl(ArchiveClassLoader $cp, $name) {
      $this->status= 1;
      Console::$out->write(sprintf('Class "%s" is part of an archive:'.PHP_EOL.' %s', $name, xp::stringOf($cp)));
    }
    
    /**
     * Get status
     *
     * @return  mixed
     */
    #[@status]
    public function getStatus() {
      return $this->status;
    }
  }
?>
