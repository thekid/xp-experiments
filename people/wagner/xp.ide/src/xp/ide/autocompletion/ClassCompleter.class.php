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
  class xp·ide·autocompletion·ClassCompleter extends xp·ide·autocompletion·Completer {

    /**
     * unfiltered possible elements
     *
     * @return  string[]
     */
    protected function elements() {
      $classes= array();
      try {
        $classes= Package::forName($this->package)->getClassNames();
      } catch(XPException $e) {
      }
      return $classes;
    }

  }
?>
