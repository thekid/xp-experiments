<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'lang.Enum', 
    'Profileable', 
    'tests.Fixture', 
    'tests.FixtureExtension',
    'tests.ObjectExtension',
    'tests.GenericExtension'
  );

  /**
   * Profiles extension versus instance methods
   *
   */
  abstract class ExtensionMethodPerformance extends Enum implements Profileable {
    public static
      $instance,
      $class_extension,
      $subclass_extension,
      $interface_extension;
    
    protected static
      $fixture;
    
    static function __static() {
      self::$fixture= new tests·Fixture();
      self::$instance= newinstance(__CLASS__, array(0, 'instance'), '{
        static function __static() { }
        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            parent::$fixture->inc($i);
          }
        }
      }');
      self::$class_extension= newinstance(__CLASS__, array(1, 'class_extension'), '{
        static function __static() { }
        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            parent::$fixture->dec($i);
          }
        }
      }');
      self::$subclass_extension= newinstance(__CLASS__, array(2, 'subclass_extension'), '{
        static function __static() { }
        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            parent::$fixture->obj($i);
          }
        }
      }');
      self::$interface_extension= newinstance(__CLASS__, array(3, 'interface_extension'), '{
        static function __static() { }
        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            parent::$fixture->gen($i);
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
