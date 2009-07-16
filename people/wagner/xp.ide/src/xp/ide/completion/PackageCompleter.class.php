<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.completion';
  
  uses(
    'lang.reflect.Package',
    'xp.ide.completion.Completer'
  );

  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·completion·PackageCompleter extends xp·ide·completion·Completer {

    /**
     * unfiltered possible elements
     *
     * @return  string[]
     */
    protected function elements() {
      $packages= array();
      try {
        $packages= Package::forName($this->uncomplete->getComplete())->getPackageNames();
      } catch(XPException $e) {
      }
      return array_map(create_function('$e', 'return $e.".";'), $packages);
    }

  }
?>
