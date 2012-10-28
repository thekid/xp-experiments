<?php
  uses('unittest.TestCase');

  class CreateTypesTest extends TestCase {

    #[@test]
    public function generic_type() {
      $this->assertInstanceOf(
        'Preference<ContentType>', 
        create('new Preference<ContentType>', 'text/html,text/xml')
      );
    }

    #[@test]
    public function reference_type() {
      $this->assertEquals(
        new ContentType('text/html'),
        create('new ContentType', 'text/html')
      );
    }

    #[@test]
    public function array_type() {
      $this->assertEquals(
        array(1, 2, 3), 
        create('new int[]', array(1, 2, 3))
      );
    }

    #[@test]
    public function array_type_default() {
      $this->assertEquals(
        array(), 
        create('new int[]')
      );
    }

    #[@test]
    public function map_type() {
      $this->assertEquals(
        array('one' => 1, 'two' => 2), 
        create('new [:int]', array('one' => 1, 'two' => 2))
      );
    }

    #[@test]
    public function map_type_default() {
      $this->assertEquals(
        array(), 
        create('new [:int]')
      );
    }

    #[@test]
    public function int_type() {
      $this->assertEquals(
        1, 
        create('new int', 1)
      );
    }

    #[@test]
    public function int_type_default() {
      $this->assertEquals(
        0, 
        create('new int')
      );
    }

    #[@test]
    public function string_type() {
      $this->assertEquals(
        '', 
        create('new string')
      );
    }
  }
?>