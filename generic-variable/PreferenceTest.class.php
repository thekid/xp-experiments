<?php
  uses('unittest.TestCase', 'Preference', 'ContentType');

  class PreferenceTest extends TestCase {

    #[@test]
    public function match() {
      $fixture= create('new Preference<ContentType>', 'text/html,text/xml');
      $this->assertEquals(
        new ContentType('text/html'), 
        $fixture->match(array('text/html'))
      );
    }

    #[@test]
    public function all() {
      $fixture= create('new Preference<ContentType>', 'text/html,text/xml');
      $this->assertEquals(
        array(new ContentType('text/html'), new ContentType('text/xml')),
        $fixture->all()
      );
    }
  }
?>