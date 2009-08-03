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
  class xp·ide·completion·ClassCompleter extends xp·ide·completion·Completer {

    /**
     * unfiltered possible elements
     *
     * @param   string $complete
     * @return  string[]
     */
    protected function elements($complete) {
      $classes= array();
      try {
        $classes= Package::forName($complete)->getClassNames();
      } catch(XPException $e) {
      }
      return $classes;
    }

  }
?>
