<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.streams.XmlStreamReader',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.streams.XmlStreamReader
   */
  class XmlStreamReaderTest extends TestCase {
    const XML_DECLARATION = '<?xml version="1.0" encoding="iso-8859-1"?>';
  
    /**
     * Creates a
     *
     * @param     string xml
     * @return    xml.streams.XmlStreamReader
     */
    protected function newReader($xml) {
      return new XmlStreamReader(new MemoryInputStream($xml));
    }

    /**
     * Test
     *
     */
    #[@test, @expect('xml.XMLFormatException')]
    public function parseEmpty() {
      $this->newReader('')->next();
    }

    /**
     * Test
     *
     */
    #[@test, @expect('xml.XMLFormatException')]
    public function unclosedElement() {
      $r= $this->newReader('<root>');
      $this->assertEquals(1, $r->next());
      $r->next();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function declarationOnly() {
      $r= $this->newReader(self::XML_DECLARATION);
      $this->assertEquals(0, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootNode() {
      $r= $this->newReader(self::XML_DECLARATION.'<root></root>');
      $this->assertEquals(1, $r->next());
      $this->assertEquals(2, $r->next());
      $this->assertEquals(0, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function documentWithoutDeclaration() {
      $r= $this->newReader('<root></root>');
      $this->assertEquals(1, $r->next());
      $this->assertEquals(2, $r->next());
      $this->assertEquals(0, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function emptyRootNode() {
      $r= $this->newReader(self::XML_DECLARATION.'<root/>');
      $this->assertEquals(1, $r->next());
      $this->assertEquals(2, $r->next());
      $this->assertEquals(0, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootAndEmptyChild() {
      $r= $this->newReader(self::XML_DECLARATION.'<root><child/></root>');
      $this->assertEquals(1, $r->next());
      $this->assertEquals(1, $r->next());
      $this->assertEquals(2, $r->next());
      $this->assertEquals(2, $r->next());
      $this->assertEquals(0, $r->next());
    }
  }
?>
