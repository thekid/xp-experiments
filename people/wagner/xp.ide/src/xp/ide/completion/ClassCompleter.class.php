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
     * @return  string[]
     */
    protected function elements() {
      $classes= array();
      try {
        $classes= Package::forName($this->uncomplete->getComplete())->getClassNames();
      } catch(XPException $e) {
      }
      return $classes;
    }

  }
?>
