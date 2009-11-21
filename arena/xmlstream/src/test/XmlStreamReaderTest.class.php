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
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $r->next();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function declarationOnly() {
      $r= $this->newReader(self::XML_DECLARATION);
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootNode() {
      $r= $this->newReader(self::XML_DECLARATION.'<root></root>');
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function documentWithoutDeclaration() {
      $r= $this->newReader('<root></root>');
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function emptyRootNode() {
      $r= $this->newReader(self::XML_DECLARATION.'<root/>');
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootNodeWithText() {
      $r= $this->newReader(self::XML_DECLARATION.'<root>Hello</root>');
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$CHARACTERS, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootNodeWithComment() {
      $r= $this->newReader(self::XML_DECLARATION.'<root><!-- Hello --></root>');
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$COMMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootNodeWithPI() {
      $r= $this->newReader(self::XML_DECLARATION.'<root><?php echo "Hello"; ?></root>');
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$PROCESSING_INSTRUCTION, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootAndEmptyChild() {
      $r= $this->newReader(self::XML_DECLARATION.'<root><child/></root>');
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$START_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_ELEMENT, $r->next());
      $this->assertEquals(XmlEventType::$END_DOCUMENT, $r->next());
    }
  }
?>
