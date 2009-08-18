<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  
  $package= 'xp.ide.source.parser';

  /**
   * methods to extend the parser
   * this should be in the parent class
   *
   * @purpose  Parser implementation
   */
  class xp·ide·source·parser·ParserHelper extends Object {

    public static function unquote($string) {
      $q= $string{0};
      return str_replace('\\'.$q, $q, substr($string, 1, -1));
    }

  }
?>
