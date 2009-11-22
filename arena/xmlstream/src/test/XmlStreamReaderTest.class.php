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
    protected static $DECL_STRING = '';
    protected static $DECL_EVENT  = NULL;
    
    static function __static() {
      self::$DECL_STRING= '<?xml version="1.0" encoding="iso-8859-1"?>';
      self::$DECL_EVENT= new StartDocument(array(
        'version'   => '1.0', 
        'encoding'  => 'iso-8859-1')
      );
    }
  
    /**
     * Creates a new XML stream reader
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
      $this->assertEquals(new StartElement('root'), $r->next());
      $r->next();
    }

    /**
     * Test
     *
     */
    #[@test, @expect('xml.XMLFormatException')]
    public function unclosedTag() {
      $r= $this->newReader('<root');
      $r->next();
    }

    /**
     * Test
     *
     */
    #[@test]
    public function declarationOnly() {
      $r= $this->newReader(self::$DECL_STRING);
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootNode() {
      $r= $this->newReader(self::$DECL_STRING.'<root></root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function documentWithoutDeclaration() {
      $r= $this->newReader('<root></root>');
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function emptyRootNode() {
      $r= $this->newReader(self::$DECL_STRING.'<root/>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function text() {
      $r= $this->newReader(self::$DECL_STRING.'<root>Hello</root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new Characters('Hello'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function comment() {
      $r= $this->newReader(self::$DECL_STRING.'<root><!-- Hello --></root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(XmlEventType::$COMMENT, $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function processingInstruction() {
      $r= $this->newReader(self::$DECL_STRING.'<root><?php echo "Hello"; ?></root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new ProcessingInstruction('php', NULL), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function entityRef() {
      $r= $this->newReader(self::$DECL_STRING.'<root>&content;</root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(XmlEventType::$ENTITY_REF, $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function knownEntitiesReportedAsText() {
      $r= $this->newReader(self::$DECL_STRING.'<root>&amp;&quot;&apos;&lt;&gt;</root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new Characters('&'), $r->next());
      $this->assertEquals(new Characters('"'), $r->next());
      $this->assertEquals(new Characters('\''), $r->next());
      $this->assertEquals(new Characters('<'), $r->next());
      $this->assertEquals(new Characters('>'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function entityRefInsideText() {
      $r= $this->newReader(self::$DECL_STRING.'<root>Content [&content;]</root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new Characters('Content ['), $r->next());
      $this->assertEquals(XmlEventType::$ENTITY_REF, $r->next());
      $this->assertEquals(new Characters(']'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function cData() {
      $r= $this->newReader(self::$DECL_STRING.'<root><![CDATA[ Hello ]]></root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(XmlEventType::$CDATA, $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function rootAndEmptyChild() {
      $r= $this->newReader(self::$DECL_STRING.'<root><child/></root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new StartElement('child'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test
     *
     */
    #[@test]
    public function docType() {
      $r= $this->newReader(self::$DECL_STRING.'<!DOCTYPE book SYSTEM "book.dtd"><root/>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(XmlEventType::$DOCTYPE, $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
    }
  }
?>
