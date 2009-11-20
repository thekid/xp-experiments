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
     * Test closeDocument() method
     *
     */
    #[@test]
    public function closeDocument() {
      $this->writer->startDocument();
      $this->writer->closeDocument();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test closeDocument() method
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function closeDocumentBeforeStart() {
      $this->writer->closeDocument();
    }

    /**
     * Test closeDocument() method
     *
     */
    #[@test]
    public function closeDocumentClosesOpenTags() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->closeDocument();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root></root>', 
        $this->stream->getBytes()
      );
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
     * Test startNode() and closeNode() methods
     *
     */
    #[@test]
    public function completeRootNode() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->closeNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root></root>', 
        $this->stream->getBytes()
      );
    }

    /**
     * Test startNode() and closeNode() methods
     *
     */
    #[@test]
    public function childNode() {
      $this->writer->startDocument();
      $this->writer->startNode('root');
      $this->writer->startNode('document');
      $this->writer->closeNode();
      $this->writer->closeNode();
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
      $this->writer->closeNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>Hello</root>', 
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
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
      $this->writer->closeNode();
      $this->assertEquals(
        '<?xml version="1.0" encoding="iso-8859-1"?><root>&data;</root>', 
        $this->stream->getBytes()
      );
    }
  }
?>
