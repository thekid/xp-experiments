<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.xdom.Document',
    'xml.xdom.Node'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.xdom.Document
   */
  class DocumentTest extends TestCase {
  
    /**
     * Test
     *
     */
    #[@test]
    public function newDoc() {
      $doc= new Document(new Node('root'));
      $this->assertEquals('root', $doc->rootElement()->getName());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function childrenSize() {
      $doc= new Document(new Node('web-app'));
      $this->assertEquals(0, $doc->rootElement()->children()->size());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function childrenAreInitiallyEmpty() {
      $doc= new Document(new Node('web-app'));
      $this->assertTrue($doc->rootElement()->children()->isEmpty());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function addChild() {
      $doc= new Document(new Node('web-app'));
      with ($children= $doc->rootElement()->children()); {
        $children->add(new Node('description'));
        $this->assertEquals(1, $children->size());
        $this->assertFalse($children->isEmpty());
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function removeChild() {
      $doc= new Document(new Node('web-app'));
      with ($children= $doc->rootElement()->children()); {
        $children->add(new Node('description'));
        $children->remove(0);
        $this->assertEquals(0, $children->size());
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function insertChild() {
      $doc= new Document(new Node('web-app'));
      with ($children= $doc->rootElement()->children()); {
        $children->add(new Node('description'));
        $children->insert(0, new Node('distributable'));
        $this->assertEquals('distributable', $children->get(0)->getName());
        $this->assertEquals('description', $children->get(1)->getName());
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function getChild() {
      $doc= new Document(new Node('web-app'));
      with ($children= $doc->rootElement()->children()); {
        $children->add(new Node('description'));
        $this->assertEquals('description', $children->get(0)->getName());
      }
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.IndexOutOfBoundsException')]
    public function getChildFromEmpty() {
      $doc= new Document(new Node('web-app'));
      $doc->rootElement()->children()->get(0);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.IndexOutOfBoundsException')]
    public function getChildViaNegative() {
      $doc= new Document(new Node('web-app'));
      $doc->rootElement()->children()->get(-1);
    }

    /**
     * Test
     *
     */
    #[@test, @expect('lang.IndexOutOfBoundsException')]
    public function nonExistantChild() {
      $doc= new Document(new Node('web-app'));
      with ($children= $doc->rootElement()->children()); {
        $children->add(new Node('description'));
        $doc->rootElement()->children()->get(1);
      }
    }

    /**
     * Test
     *
     */
    #[@test]
    public function clear() {
      $doc= new Document(new Node('web-app'));
      with ($children= $doc->rootElement()->children()); {
        $children->add(new Node('description'));
        $children->clear();
        $this->assertEquals(0, $children->size());
      }
    }
  }
?>
