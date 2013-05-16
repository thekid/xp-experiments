<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('lang.Enum', 'Profileable', 'Clazz');

  /**
   * Method calls profiling
   *
   * @purpose  Profiling
   */
  abstract class Arrays extends Enum implements Profileable {
    public static
      $array,
      $array_cached,
      $arrayobject,
      $arrayobject_cached,
      $iteration,
      $iteration_cached,
      $object,
      $object_cached;
    
    static function __static() {
      self::$array= newinstance(__CLASS__, array(0, 'array'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->getMethods() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
      self::$array_cached= newinstance(__CLASS__, array(1, 'array_cached'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->getMethodsCached() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
      self::$arrayobject= newinstance(__CLASS__, array(2, 'arrayobject'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->listMethods() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
      self::$arrayobject_cached= newinstance(__CLASS__, array(3, 'arrayobject_cached'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->listMethodsCached() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
      self::$iteration= newinstance(__CLASS__, array(4, 'iteration'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->methodIterator() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
      self::$iteration_cached= newinstance(__CLASS__, array(5, 'iteration_cached'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->methodIteratorCached() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
      self::$object= newinstance(__CLASS__, array(6, 'object'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->methods() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
      self::$object_cached= newinstance(__CLASS__, array(7, 'object_cached'), '{
        static function __static() { }

        public function run($times) {
          $class= Clazz::forName("lang.XPClass");
          for ($i= 0; $i < $times; $i++) {
            $names= array();
            foreach ($class->methodsCached() as $method) {
              $names[]= $method->name();
            }
          }
          $this->assertEqual(40, sizeof($names));
        }
      }');
    }
    
    /**
     * Assert two values are equal
     *
     * @param   * a
     * @param   * b
     * @throws  lang.IllegalStateException
     */
    public function assertEqual($a, $b) {
      if ($a !== $b) throw new IllegalStateException($a.' != '.$b);
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
