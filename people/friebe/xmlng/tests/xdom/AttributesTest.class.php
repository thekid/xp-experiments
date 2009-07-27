<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.xdom.Node'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.xdom.Node
   */
  class AttributesTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function nodeWithoutAttributes() {
      $this->assertFalse(create(new Node('root'))->hasAttribute('any'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function nodeWitAttribute() {
      $this->assertTrue(create(new Node('a', array('href' => '#top')))->hasAttribute('href'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function nodeWitAttributes() {
      $n= new Node('img', array('src' => '/blank.gif', 'border' => '0'));
      $this->assertTrue($n->hasAttribute('src'));
      $this->assertTrue($n->hasAttribute('border'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function getAttributes() {
      $n= new Node('img', array('src' => '/blank.gif', 'border' => '0'));
      $this->assertEquals('/blank.gif', $n->getAttribute('src')->getValue());
      $this->assertEquals('0', $n->getAttribute('border')->getValue());
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function getNonExistantAttribute() {
      create(new Node('root'))->getAttribute('any');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function setAttribute() {
      $n= new Node('root');
      $n->setAttribute('key', 'value');
      $this->assertTrue($n->hasAttribute('key'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function setAttributeObject() {
      $n= new Node('root');
      $n->setAttribute(new Attribute('key', 'value'));
      $this->assertTrue($n->hasAttribute('key'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function remove() {
      $n= new Node('root', array('key' => 'value'));
      $n->removeAttribute('key');
      $this->assertFalse($n->hasAttribute('key'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function withAttributeReturnsNode() {
      $n= new Node('root');
      $this->assertEquals($n, $n->withAttribute('any', 'key'));
    }
  }
?>
