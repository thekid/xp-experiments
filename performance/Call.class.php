<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.Enum', 'Profileable');

  /**
   * Test whether __call makes a difference
   *
   * @purpose  Profiling
   */
  abstract class Call extends Enum implements Profileable {
    public static
      $with,
      $withProtected,
      $withPrivate,
      $without,
      $withoutProtected,
      $withoutPrivate;
    
    static function __static() {
      self::$with= newinstance(__CLASS__, array(0, 'with'), '{
        static function __static() { }
        public function target($i) {
          $i++;
        }
        
        public function __call($name, $args) {
          raise("lang.MethodNotImplementedException", $this->getClassName()."::".$name);
        }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $this->target($i);
          }
        }
      }');
      self::$withProtected= newinstance(__CLASS__, array(1, 'withProtected'), '{
        static function __static() { }
        protected function target($i) {
          $i++;
        }

        public function __call($name, $args) {
          raise("lang.MethodNotImplementedException", $this->getClassName()."::".$name);
        }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $this->target($i);
          }
        }
      }');
      self::$withPrivate= newinstance(__CLASS__, array(2, 'withPrivate'), '{
        static function __static() { }
        private function target($i) {
          $i++;
        }

        public function __call($name, $args) {
          raise("lang.MethodNotImplementedException", $this->getClassName()."::".$name);
        }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $this->target($i);
          }
        }
      }');
      self::$without= newinstance(__CLASS__, array(3, 'without'), '{
        static function __static() { }
        public function target($i) {
          $i++;
        }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $this->target($i);
          }
        }
      }');
      self::$withoutProtected= newinstance(__CLASS__, array(4, 'withoutProtected'), '{
        static function __static() { }
        protected function target($i) {
          $i++;
        }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $this->target($i);
          }
        }
      }');
      self::$withoutPrivate= newinstance(__CLASS__, array(5, 'withoutPrivate'), '{
        static function __static() { }
        private function target($i) {
          $i++;
        }

        public function run($times) {
          for ($i= 0; $i < $times; $i++) {
            $this->target($i);
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
