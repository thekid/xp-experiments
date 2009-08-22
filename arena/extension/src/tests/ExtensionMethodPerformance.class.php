<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('lang.Enum', 'Profileable', 'tests.Fixture', 'tests.FixtureExtension');

  /**
   * Profiles extension versus instance methods
   *
   */
  abstract class ExtensionMethodPerformance extends Enum implements Profileable {
    public static
      $instance,
      $extension;
    
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
      self::$extension= newinstance(__CLASS__, array(0, 'extension'), '{
        static function __static() { }
        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            parent::$fixture->dec($i);
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
