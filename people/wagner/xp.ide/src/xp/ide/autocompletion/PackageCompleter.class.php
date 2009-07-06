<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.autocompletion';
  
  uses(
    'lang.reflect.Package',
    'xp.ide.autocompletion.Completer'
  );

  /**
   * Autocomleter for xp classes
   *
   * @purpose  IDE
   */
  class xp·ide·autocompletion·PackageCompleter extends xp·ide·autocompletion·Completer {

    /**
     * unfiltered possible elements
     *
     * @return  string[]
     */
    protected function elements() {
      $packages= array();
      try {
        $packages= Package::forName($this->package)->getPackageNames();
      } catch(XPException $e) {
      }
      return array_map(create_function('$e', 'return $e.".";'), $packages);
    }

  }
?>
