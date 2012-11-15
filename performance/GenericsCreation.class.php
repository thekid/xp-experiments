<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.Enum', 'Profileable', 'util.collections.Vector');

  /**
   * Generics creation profiling
   *
   */
  abstract class GenericsCreation extends Enum implements Profileable {
    public static
      $vector,
      $vector_of_string,
      $vector_of_object;
    
    static function __static() {
      self::$vector= newinstance(__CLASS__, array(0, 'vector'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $v= new Vector();
          }
        }
      }');
      self::$vector_of_string= newinstance(__CLASS__, array(1, 'vector_of_string'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $v= create("new Vector<string>");
          }
        }
      }');
      self::$vector_of_object= newinstance(__CLASS__, array(2, 'vector_of_object'), '{
        static function __static() { }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $v= create("new Vector<Object>");
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
