<?php
  uses('unittest.TestCase', 'Preference', 'ContentType');

  class PreferenceTest extends TestCase {

  	#[@test]
  	public function content_type() {
      $fixture= create('new Preference<ContentType>', 'text/html,text/xml');
      $this->assertEquals(
      	new ContentType('text/html'), 
      	$fixture->match(array('text/html'))
      );
  	}
  }
?>