<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.streams.XmlStreamWriter',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.streams.XmlStreamWriter
   */
  class XmlStreamWriterTest extends TestCase {
    protected $stream= NULL;
    protected $writer= NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->stream= new MemoryOutputStream();
      $this->writer= new XmlStreamWriter($this->stream);
    }

    /**
     * Test
     *
     */
    #[@test]
    public function initiallyEmpty() {
      $this->assertEquals('', $this->stream->getBytes());
    }

    /**
     * Test startDocument() method
     *
     */
    #[@test]
    public function startDocument() {
      $this->writer->startDocument();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startDocument() method
     *
     */
    #[@test]
    public function startUtf8Document() {
      $this->writer->startDocument('utf-8');
      $this->assertEquals(
        '<?xml version="1.0" encoding="utf-8"?>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startDocument() method
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function startDocumentTwice() {
      $this->writer->startDocument();
      $this->writer->startDocument();
    }

    /**
     * Test endDocument() method
     *
     */
    #[@test]
    public function endDocument() {
      $this->writer->startDocument();
      $this->writer->endDocument();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test endDocument() method
     *
     */
    #[@test, @expect(class= 'lang.IllegalStateException', withMessage= 'Document not yet started')]
    public function endDocumentBeforeStart() {
      $this->writer->endDocument();
    }

    /**
     * Test endDocument() method
     *
     */
    #[@test, @expect(class= 'lang.IllegalStateException', withMessage= 'Document previously ended')]
    public function endAlreadyEndedDocument() {
      $this->writer->startDocument();
      $this->writer->endDocument();
      $this->writer->endDocument();
    }

    /**
     * Test endDocument() method
     *
     */
    #[@test]
    public function endDocumentClosesOpenTags() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->endDocument();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeDocType() method
     *
     */
    #[@test]
    public function xhtmlTransitionalDocType() {
      $this->writer->startDocument();
      $this->writer->writeDocType(
        'html', 
        '-//W3C//DTD XHTML 1.0 Transitional//EN', 
        'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'
      );
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?>'.
        '<!DOCTYPE html PUBLIC'.
        ' "-//W3C//DTD XHTML 1.0 Transitional//EN"'.
        ' "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"'.
        '>',
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeDocType() method
     *
     */
    #[@test]
    public function systemDocType() {
      $this->writer->startDocument();
      $this->writer->writeDocType('book', NULL, 'book.dtd');
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><!DOCTYPE book SYSTEM "book.dtd">',
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeDocType() method
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function writeDocTypeBeforDocumentStart() {
      $this->writer->writeDocType('any', NULL, 'any.dtd');
    }

    /**
     * Test startNode() method
     *
     */
    #[@test]
    public function writeRootNode() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startNode() method
     *
     */
    #[@test]
    public function withAttribute() {
      $this->writer->startDocument();
      $this->writer->startNode('root', array('version' => '1.0'));
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root version="1.0">', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startNode() method
     *
     */
    #[@test]
    public function withAttributes() {
      $this->writer->startDocument();
      $this->writer->startNode('root', array('version' => '1.0', 'id' => '-//XP/5.7.6'));
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root version="1.0" id="-//XP/5.7.6">', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startNode() method
     *
     */
    #[@test]
    public function withAttributeContainingSpecialChars() {
      $this->writer->startDocument();
      $this->writer->startNode('root', array('name' => '<Hello&>'));
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root name="&lt;Hello&amp;&gt;">', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startNode() method
     *
     */
    #[@test]
    public function withAttributeContainingQuotes() {
      $this->writer->startDocument();
      $this->writer->startNode('root', array('name' => '"Hello"'));
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root name="&quot;Hello&quot;">', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeEmptyNode() method
     *
     */
    #[@test]
    public function emptyRootNode() {
      $this->writer->startDocument();
      $this->writer->writeEmptyNode('root');
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root/>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startNode() and endNode() methods
     *
     */
    #[@test]
    public function completeRootNode() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test endNode() method
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function endNodeWithoutStart() {
      $this->writer->startDocument();
      $this->writer->endNode();
    }

    /**
     * Test endNode() method
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function endNodeTooOften() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->endNode();
      $this->writer->endNode();
    }

    /**
     * Test startNode() and endNode() methods
     *
     */
    #[@test]
    public function childNode() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->startNode('document');
      $this->writer->endNode();
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root><document></document></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeCharacters() method
     *
     */
    #[@test]
    public function writeCharacters() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCharacters('Hello');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>Hello</root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeCharacters() method
     *
     */
    #[@test]
    public function writeCharactersMultipleCallsConcatenate() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCharacters('Hello');
      $this->writer->writeCharacters(' ');
      $this->writer->writeCharacters('World');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>Hello World</root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeCharacters() method escapes special chars
     *
     */
    #[@test]
    public function writeCharactersEscapesSpecial() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCharacters('<nedit&>');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>&lt;nedit&amp;&gt;</root>', 
        $this->stream->getBytes()
      );
    }
 
    /**
     * Test writeCharacters() method does not escape double quotes
     *
     */
    #[@test]
    public function writeCharactersDoesNotEscapeDoubleQuotes() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCharacters('"Hello"');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>"Hello"</root>', 
        $this->stream->getBytes()
      );
    }
 
    /**
     * Test writeCharacters() method does not escape single quotes
     *
     */
    #[@test]
    public function writeCharactersDoesNotEscapeSingleQuotes() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCharacters('\'Hello\'');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>\'Hello\'</root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeCharacters() method
     *
     */
    #[@test]
    public function writeUtf8Characters() {
      $this->writer->startDocument('utf-8');
      $this->writer->startNode('root');
      $this->writer->writeCharacters('Übercoder');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="utf-8"?><root>Ãœbercoder</root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeCharacters() method
     *
     */
    #[@test]
    public function writeLatin1Characters() {
      $this->writer->startDocument('iso-8859-1');
      $this->writer->startNode('root');
      $this->writer->writeCharacters('Übercoder');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>Übercoder</root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeCData() method
     *
     */
    #[@test]
    public function writeCData() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCData('Hello');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root><![CDATA[Hello]]></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeCData() method
     *
     */
    #[@test]
    public function writeCDataWithCDataEndInside() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCData('Hello]]>');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root><![CDATA[Hello]]]]><![CDATA[>]]></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeComment() method
     *
     */
    #[@test]
    public function writeComment() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeComment('Hello');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root><!-- Hello --></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeProcessingInstruction() method
     *
     */
    #[@test]
    public function writeProcessingInstruction() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeProcessingInstruction('php', 'echo "Hello";');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root><?php echo "Hello"; ?></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test writeEntityRef() method
     *
     */
    #[@test]
    public function writeEntityRef() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeEntityRef('data');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>&data;</root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test setNewLines() method
     *
     */
    #[@test, @ignore('Newlines and indenting not supported currently')]
    public function setNewLines() {
      $this->writer->setNewLines();
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeEmptyNode('child');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?>'."\n".
        '<root>'."\n".
        '<child/>'."\n".
        '</root>',
        $this->stream->getBytes()
      );
    }

    /**
     * Test setNewLines() method
     *
     */
    #[@test, @ignore('Newlines and indenting not supported currently')]
    public function setNewLinesAndIndent() {
      $this->writer->setNewLines();
      $this->writer->setIndent('  ');
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeEmptyNode('child');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?>'."\n".
        '<root>'."\n".
        '  <child/>'."\n".
        '</root>',
        $this->stream->getBytes()
      );
    }

    /**
     * Test setNewLines() method
     *
     */
    #[@test, @ignore('Newlines and indenting not supported currently')]
    public function newLinesDoNotSurroundContent() {
      $this->writer->setNewLines();
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCharacters('Hello');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?>'."\n".
        '<root>Hello</root>',
        $this->stream->getBytes()
      );
    }

    /**
     * Test writing markup
     *
     */
    #[@test]
    public function markup() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->writeCharacters('Hello');
      $this->writer->writeEmptyNode('br');
      $this->writer->writeCharacters('World');
      $this->writer->endNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>Hello<br/>World</root>',
        $this->stream->getBytes()
      );
    }
  }
?>
