<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.streams.events.StartDocument'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.streams.events.StartDocument
   */
  class StartDocumentEventTest extends TestCase {
  
    /**
     * Test attribute() method
     *
     */
    #[@test]
    public function iso88591Encoding() {
      $this->assertEquals(
        'iso-8859-1', 
        create(new StartDocument(array('encoding' => 'iso-8859-1')))->attribute('encoding')
      );
    }

    /**
     * Test attribute() method
     *
     */
    #[@test]
    public function utf8Encoding() {
      $this->assertEquals(
        'utf-8', 
        create(new StartDocument(array('encoding' => 'utf-8')))->attribute('encoding')
      );
    }

    /**
     * Test attribute() method
     *
     */
    #[@test]
    public function noEncoding() {
      $this->assertEquals(
        NULL, 
        create(new StartDocument(array()))->attribute('encoding')
      );
    }
    
    /**
     * Test attribute() method
     *
     */
    #[@test]
    public function attributeDefault() {
      $this->assertEquals(
        'utf-8', 
        create(new StartDocument(array()))->attribute('encoding', 'utf-8')
      );
    }

    /**
     * Test attributes() method
     *
     */
    #[@test]
    public function allAttributes() {
      $attributes= array('encoding' => 'utf-8', 'version' => '1.0');
      $this->assertEquals(
        $attributes,
        create(new StartDocument($attributes))->attributes()
      );
    }

    /**
     * Test type() method
     *
     */
    #[@test]
    public function eventType() {
      $this->assertEquals(
        XmlEventType::$START_DOCUMENT,
        create(new StartDocument(array()))->type()
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function twoInstancesWithEmptyAttributesAreEqual() {
      $this->assertEquals(
        new StartDocument(array()),
        new StartDocument(array())
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function twoInstancesWithSameAttributesAreEqual() {
      $attributes= array('encoding' => 'utf-8', 'version' => '1.0');
      $this->assertEquals(
        new StartDocument($attributes),
        new StartDocument($attributes)
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function twoInstancesWithSameAttributesOrderedDifferentlyAreEqual() {
      $this->assertEquals(
        new StartDocument(array('encoding' => 'utf-8', 'version' => '1.0')),
        new StartDocument(array('version' => '1.0', 'encoding' => 'utf-8'))
      );
    }

    /**
     * Test equals() method
     *
     */
    #[@test]
    public function notEqual() {
      $this->assertNotEquals(
        new StartDocument(array('encoding' => 'utf-8', 'version' => '1.0')),
        new StartDocument(array('encoding' => 'iso-8859-1', 'version' => '1.0'))
      );
    }
  }
?>
