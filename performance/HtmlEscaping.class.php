<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum', 'Profileable');

  /**
   * HTML escaping profiling
   *
   */
  abstract class HtmlEscaping extends Enum implements Profileable {
    public static
      $htmlspecialchars,
      $strtr;
    
    static function __static() {
      self::$htmlspecialchars= newinstance(__CLASS__, array(0, 'htmlspecialchars'), '{
        static function __static() { }

        public function run($times) {
          $in= "<He said: \"Hello & World\">";
          for ($i= 0; $i < $times; $i++) {
            htmlspecialchars($in);
          }
        }
      }');
      self::$strtr= newinstance(__CLASS__, array(1, 'strtr'), '{
        static function __static() { }

        public function run($times) {
          $in= "<He said: \"Hello & World\">";
          $r= array("&" => "&amp;", "\"" => "&quot;", "<" => "&lt;", ">" => "&gt;");
          for ($i= 0; $i < $times; $i++) {
            strtr($in, $r);
          }
        }
      }');
    }
    
    /**
     * Returns all enum members
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }
  }
?>
