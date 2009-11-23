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
     * Test an empty document is considered not well-formed
     *
     */
    #[@test, @expect('xml.XMLFormatException')]
    public function parseEmpty() {
      $this->newReader('')->next();
    }

    /**
     * Test unclosed element are reported as parse error
     *
     */
    #[@test, @expect('xml.XMLFormatException')]
    public function unclosedElement() {
      $r= $this->newReader('<root>');
      $this->assertEquals(new StartElement('root'), $r->next());
      $r->next();
    }

    /**
     * Test unclosed tags are reported as parse error
     *
     */
    #[@test, @expect('xml.XMLFormatException')]
    public function unclosedTag() {
      $r= $this->newReader('<root');
      $r->next();
    }

    /**
     * Test parsing a document consisting only of a declaration
     *
     */
    #[@test]
    public function declarationOnly() {
      $r= $this->newReader(self::$DECL_STRING);
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test parsing a document with declaration and root node
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
     * Test parsing a document with declaration and root node
     *
     */
    #[@test]
    public function rootNodeWithAttributes() {
      $r= $this->newReader(self::$DECL_STRING.'<root id="AAAE-7F"></root>');
      $this->assertEquals(self::$DECL_EVENT, $r->next());
      $this->assertEquals(new StartElement('root', array('id' => 'AAAE-7F')), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }

    /**
     * Test parsing a document without declaration
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
      $this->assertEquals(new Comment(NULL), $r->next());
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
      $this->assertEquals(new EntityRef('content'), $r->next());
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
      $this->assertEquals(new EntityRef('content'), $r->next());
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
      $this->assertEquals(new CData(NULL), $r->next());
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
      $this->assertEquals(new DocTypeSystem('book'), $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function readUtf8EncodedCharacters() {
      $r= $this->newReader('<?xml version="1.0" encoding="utf-8"?><root>Ãœbercoder</root>');
      $this->assertEquals(new StartDocument(array('version' => '1.0', 'encoding' => 'utf-8')), $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new Characters('Übercoder'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function readUtf8EncodedCharactersWithoutEncodingDeclaration() {
      $r= $this->newReader('<?xml version="1.0"?><root>Ãœbercoder</root>');
      $this->assertEquals(new StartDocument(array('version' => '1.0')), $r->next());
      $this->assertEquals(new StartElement('root'), $r->next());
      $this->assertEquals(new Characters('Übercoder'), $r->next());
      $this->assertEquals(new EndElement(), $r->next());
      $this->assertEquals(new EndDocument(), $r->next());
    }
  }
?>
