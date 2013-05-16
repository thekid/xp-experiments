<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.xdom.Node
   * @see      xp://xml.xdom.XMLNamespace
   */
  class NamespacedNodesTest extends TestCase {
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
    public function qualifiedName() {
      $doc= new Document(new Node('stylesheet', array(), $this->xslns));
      $this->assertEquals('xsl:stylesheet', $doc->rootElement()->qualifiedName());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function qualifiedNameInherited() {
      $doc= new Document(new Node('stylesheet', array(), $this->xslns));
      with ($root= $doc->rootElement()); {
        $root->addChild(new Node('output', array('method' => 'html')));
        $this->assertEquals('xsl:output', $root->children()->get(0)->qualifiedName());
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function qualifiedNameChild() {
      $doc= new Document(new Node('stylesheet', array(), $this->xslns));
      with ($root= $doc->rootElement()); {
        $root->addChild(new Node('output', array('method' => 'html'), $this->xslns));
        $this->assertEquals('xsl:output', $root->children()->get(0)->qualifiedName());
      }
    }
  }
?>
