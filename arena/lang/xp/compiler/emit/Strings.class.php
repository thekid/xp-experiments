<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * String emittance utilities
   *
   */
  class Strings extends Object {
    
    /**
     * Expand escape sequences inside a given string and return it
     *
     * @param   string in
     * @return  string out
     * @throws  lang.FormatException in case an illegal escape sequence is encountered
     */
    public static function expandEscapesIn($in) {
      if (0 === ($s= strlen($in))) return $in;

      $offset= 0;
      $out= '';
      while (FALSE !== ($p= strpos($in, '\\', $offset))) {
        $out.= substr($in, $offset, $p- $offset);
        $offset= $p+ 1;
        if ($offset >= $s || '\\' == $in{$offset}) {
          $out.= '\\';
        } else if ('r' === $in{$offset}) {
          $out.= "\r";
        } else if ('n' === $in{$offset}) {
          $out.= "\n";
        } else if ('t' === $in{$offset}) {
          $out.= "\t";
        } else {
          throw new FormatException('Illegal escape sequence \\'.$in{$offset}.' in '.$in);
        }
        if (++$offset > $s) break;
      }
      return $out.substr($in, $offset);
    }
    
  }
?>
