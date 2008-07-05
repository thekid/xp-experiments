<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'unittest.web';
  
  uses('lang.Enum', 'unittest.web.InputField');

  /**
   * Represents a HTML field
   *
   * @see      xp://unitform.web.Form#getFields
   * @purpose  Base class
   */
  abstract class unittest·web·Fields extends Enum {
    public static $INPUT, $SELECT, $TEXTAREA;
  
    static function __static() {
      self::$INPUT= newinstance(__CLASS__, array(0, 'INPUT'), '{
        static function __static() { }
        
        public function newInstance($form, $node) {
          return new unittest·web·InputField($form, $node);
        }
      }');
    }
    
    /**
     * Creates a new instance of this field type
     *
     * @param   unittest.web.Form form
     * @param   php.DOMNode node
     * @return  unittest.web.Field
     */
    public abstract function newInstance($test, $node);

    /**
     * Return all values
     *
     * @return  lang.Enum[]
     */
    public static function values() {
      return parent::membersOf(__CLASS__);
    }

    /**
     * Return a field type
     *
     * @return  unittest.web.Fields
     */
    public static function forTag($type) {
      return parent::valueOf(XPClass::forName('unittest.web.Fields'), strtoupper($type));
    }
  }
?>
