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

    protected
      $top_element= NULL;

    public function getTopElement() {
      return $this->top_element;
    }

    public function setTopElement(xp·ide·source·Element $top_element) {
      $this->top_element= $top_element;
    }

    public static function unquote($string) {
      $q= $string{0};
      return str_replace('\\'.$q, $q, substr($string, 1, -1));
    }

  }
?>
