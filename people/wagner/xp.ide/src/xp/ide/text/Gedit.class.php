<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide.text';

  uses(
    'xp.ide.resolve.Gedit',
    'xp.ide.text.Nedit'
  );

  /**
   * gedit text actions
   *
   * @purpose  IDE
   */
  class xp·ide·text·Gedit extends xp·ide·text·Nedit {

    /**
     * resolver factory
     *
     * @return  xp.ide.resolve.Resolver
     */
    protected function createResolver() {
      return new xp·ide·resolve·Gedit();
    }
    
  }
?>
