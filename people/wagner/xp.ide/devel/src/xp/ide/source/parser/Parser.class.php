<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  $package= 'xp.ide.source.parser';

  uses('text.parser.generic.AbstractParser');

  /**
   * methods to extend the parser
   *
   * @purpose  Parser implementation
   */
  abstract class xp·ide·source·parser·Parser extends AbstractParser {

    public static function unquote($string) {
      $q= $string{0};
      return str_replace('\\'.$q, $q, substr($string, 1, -1));
    }

  }
?>
