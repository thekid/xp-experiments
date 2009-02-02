<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'util.invoke.ClassDistance'
  );

  /**
   * TestCase
   *
   * @see      xp://util.invoke.ClassDistance
   * @purpose  Unittest
   */
  class ClassDistanceTest extends TestCase {
    protected static 
      $objectClass          = NULL,
      $mapInterface         = NULL, 
      $hashClass            = NULL, 
      $idHashClass          = NULL,
      $eventInterface       = NULL,
      $guiEventInterface    = NULL,
      $buttonClickInterface = NULL;

    /**
     * Creates the following situation:
     *
     * <code>
     *   interface Generic { }
     *   class Object implements Generic { }
     *
     *   interface Map { } 
     *   class Hash extends Object implements Map { }
     *   class IdHash extends Hash { }
     *
     *   interface Event { }
     *   interface GuiEvent extends Event { }
     *   interface ButtonClick extends GuiEvent { }
     * </code>
     */
    #[@beforeClass]
    public static function initializeClassMembers() {
      self::$objectClass= XPClass::forName('lang.Object');
      
      self::$mapInterface= ClassLoader::defineInterface(
        'tests.RuntimeDefinedMap', 
        array(), 
        '{}'
      );
      self::$hashClass= ClassLoader::defineClass(
        'tests.RuntimeDefinedHash', 
        'lang.Object', 
        array(self::$mapInterface->getName()), 
        '{}'
      );
      self::$idHashClass= ClassLoader::defineClass(
        'tests.RuntimeDefinedIdHash', 
        self::$hashClass->getName(), 
        array(self::$mapInterface->getName()), 
        '{}'
      );
      self::$eventInterface= ClassLoader::defineInterface(
        'tests.RuntimeDefinedEvent', 
        array(), 
        '{}'
      );
      self::$guiEventInterface= ClassLoader::defineInterface(
        'tests.RuntimeDefinedGuiEvent', 
        array(self::$eventInterface->getName()), 
        '{}'
      );
      self::$buttonClickInterface= ClassLoader::defineInterface(
        'tests.RuntimeDefinedButtonClick', 
        array(self::$guiEventInterface->getName()), 
        '{}'
      );
    }
  
    /**
     * Test Distance(Object.class, Object.class)
     *
     */
    #[@test]
    public function objectObject() {
      $this->assertEquals(0, ClassDistance::between(
        self::$objectClass, 
        self::$objectClass
      ));
    }

    /**
     * Test Distance(Object.class, Generic.class)
     *
     */
    #[@test]
    public function objectGeneric() {
      $this->assertEquals(1, ClassDistance::between(
        self::$objectClass, 
        XPClass::forName('lang.Generic')
      ));
    }

    /**
     * Test Distance(Generic.class, Object.class)
     *
     */
    #[@test]
    public function genericObject() {
      $this->assertEquals(-1, ClassDistance::between(
        XPClass::forName('lang.Generic'), 
        self::$objectClass
      ));
    }

    /**
     * Test Distance(Error.class, Throwable.class)
     *
     */
    #[@test]
    public function errorThrowable() {
      $this->assertEquals(1, ClassDistance::between(
        XPClass::forName('lang.Error'), 
        XPClass::forName('lang.Throwable')
      ));
    }

    /**
     * Test Distance(Throwable.class, Error.class)
     *
     */
    #[@test]
    public function throwableError() {
      $this->assertEquals(-1, ClassDistance::between(
        XPClass::forName('lang.Throwable'), 
        XPClass::forName('lang.Error')
      ));
    }

    /**
     * Test Distance(Map.class, Generic.class)
     *
     */
    #[@test]
    public function mapGeneric() {
      $this->assertEquals(-1, ClassDistance::between(
        self::$mapInterface, 
        XPClass::forName('lang.Generic')
      ));
    }

    /**
     * Test Distance(ButtonClick.class, Event.class)
     *
     */
    #[@test]
    public function buttonClickEvent() {
      $this->assertEquals(2, ClassDistance::between(
        self::$buttonClickInterface, 
        self::$eventInterface
      ));
    }

    /**
     * Test Distance(ButtonClick.class, GuiEvent.class)
     *
     */
    #[@test]
    public function buttonClickGuiEvent() {
      $this->assertEquals(1, ClassDistance::between(
        self::$buttonClickInterface, 
        self::$guiEventInterface
      ));
    }

    /**
     * Test Distance(Hash.class, Map.class)
     *
     */
    #[@test]
    public function hashMap() {
      $this->assertEquals(1, ClassDistance::between(
        self::$hashClass, 
        self::$mapInterface
      )); 
    }
    
    /**
     * Test Distance(IdHash.class, Map.class)
     *
     */
    #[@test]
    public function idHashMap() {
      $this->assertEquals(2, ClassDistance::between(
        self::$idHashClass, 
        self::$mapInterface
      ));
    }
    
    /**
     * Test Distance(Hash.class, Object.class)
     *
     */
    #[@test]
    public function hashObject() {
      $this->assertEquals(1, ClassDistance::between(
        self::$hashClass, 
        self::$objectClass
      ));
    }
    
    /**
     * Test Distance(IdHash.class, Object.class)
     *
     */
    #[@test]
    public function idHashObject() {
      $this->assertEquals(2, ClassDistance::between(
        self::$idHashClass, 
        self::$objectClass
      ));
    }
    
    /**
     * Test Distance(Hash.class, Generic.class)
     *
     */
    #[@test]
    public function hashGeneric() {
      $this->assertEquals(2, ClassDistance::between(
        self::$hashClass, 
        XPClass::forName('lang.Generic')
      ));
    }

    /**
     * Test Distance(IdHash.class, Generic.class)
     *
     */
    #[@test]
    public function idHashGeneric() {
      $this->assertEquals(3, ClassDistance::between(
        self::$idHashClass, 
        XPClass::forName('lang.Generic')
      ));
    }
  }
?>
