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
   * @see      xp://xml.xdom.XMLNamespace
   */
  class NamespacedAttributesTest extends TestCase {
    protected $xslns, $xpns;

    /**
     * Initializes xslns and xpns members
     *
     */
    public function setUp() {
      $this->xslns= new XMLNamespace('xsl', 'http://www.w3.org/1999/XSL/Transform');
      $this->xpns= new XMLNamespace('xp', 'http://xp-framework.net/xsl');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function has() {
      $n= new Node('root');
      $n->setAttribute(new Attribute('key', 'value', $this->xslns));
      $this->assertFalse($n->hasAttribute('key'));
      $this->assertTrue($n->hasAttribute('key', $this->xslns));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function get() {
      $n= new Node('root');
      $n->setAttribute(new Attribute('key', 'value', $this->xslns));
      $this->assertEquals('value', $n->getAttribute('key', $this->xslns)->getValue());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function remove() {
      $n= create(new Node('root'))
        ->withAttribute(new Attribute('key', 'value', $this->xslns))
        ->withAttribute(new Attribute('key', 'value', $this->xpns))
        ->withAttribute(new Attribute('key', 'value'))
      ;
      $n->removeAttribute('key');
      $this->assertFalse($n->hasAttribute('key'));
      $this->assertTrue($n->hasAttribute('key', $this->xslns));
      $this->assertTrue($n->hasAttribute('key', $this->xpns));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function removeNamespaced() {
      $n= create(new Node('root'))
        ->withAttribute(new Attribute('key', 'value', $this->xslns))
        ->withAttribute(new Attribute('key', 'value', $this->xpns))
        ->withAttribute(new Attribute('key', 'value'))
      ;
      $n->removeAttribute('key', $this->xslns);
      $this->assertTrue($n->hasAttribute('key'));
      $this->assertFalse($n->hasAttribute('key', $this->xslns));
      $this->assertTrue($n->hasAttribute('key', $this->xpns));
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function getNonExistant() {
      $n= new Node('root');
      $n->setAttribute(new Attribute('key', 'value', $this->xslns));
      $n->getAttribute('key');
    }
  }
?>
