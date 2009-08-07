<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  uses(
    'lang.reflect.Package',
    'xp.ide.completion.Completer',
    'xp.ide.completion.ClassCompleter',
    'xp.ide.completion.PackageCompleter'
  );

  /**
   * Autocomleter for xp classes and packages
   *
   * @purpose  IDE
   */
  class xp·ide·completion·PackageClassCompleter extends xp·ide·completion·Completer {
    private
      $classes= NULL,
      $packages= NULL;

    /**
     * Constructor
     *
     */
    public function __construct() {
      $this->classes= new xp·ide·completion·ClassCompleter();
      $this->packages= new xp·ide·completion·PackageCompleter();
    }

    /**
     * unfiltered possible elements
     *
     * @param   string $complete
     * @return  string[]
     */
    protected function elements($complete) {
      return array_merge(
        $this->classes->elements($complete),
        $this->packages->elements($complete)
      );
    }

  }
?>
