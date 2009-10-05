<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source.snippet";

  uses(
    'xp.ide.source.snippet.Getter'
  );

  /**
   * source representation
   * base object
   *
   * @purpose  IDE
   */
  class xp搏de新ource新nippet廉etterBool extends xp搏de新ource新nippet廉etter {

    protected function  getBaseMethod($name, $type) {
      return new xp搏de新ource搪lement嵩lassmethod('is'.ucfirst($name));
    }

  }

?>
