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
     * @param   string $complete
     * @return  string[]
     */
    protected function elements($complete) {
      $packages= array();
      try {
        $packages= Package::forName($complete)->getPackageNames();
      } catch(XPException $e) {
      }
      return array_map(create_function('$e', 'return $e.".";'), $packages);
    }

  }
?>
