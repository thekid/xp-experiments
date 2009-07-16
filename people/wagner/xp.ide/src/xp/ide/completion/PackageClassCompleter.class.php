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

    /**
     * Constructor
     *
     * @param   xp.ide.completion.UncompletePackageClass $uncomplete
     */
    public function __construct(xp·ide·completion·UncompletePackageClass $uncomplete) {
      parent::__construct($uncomplete);
      $this->classes= new xp·ide·completion·ClassCompleter($uncomplete);
      $this->packages= new xp·ide·completion·PackageCompleter($uncomplete);
    }

    /**
     * unfiltered possible elements
     *
     * @return  string[]
     */
    protected function elements() {
      return array_merge(
        $this->classes->elements(),
        $this->packages->elements()
      );
    }

  }
?>
