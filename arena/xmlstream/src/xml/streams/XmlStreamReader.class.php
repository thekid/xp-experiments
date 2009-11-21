<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.streams.InputStream',
    'text.StreamTokenizer', 
    'xml.XMLFormatException', 
    'xml.streams.XmlEventType'
  );

  /**
   * Writes XML in a streaming fashion
   *
   * @ext      iconv
   * @test     xp://testXmlStreamReaderTest
   */
  class XmlStreamReader extends Object {
    protected $tokenizer = NULL;
    protected $events    = array();
    protected $open      = 0;
    
    /**
     * Creates a new XML stream writer
     *
     * @param   io.streams.OutputStream stream
     */
    public function __construct(InputStream $stream) {
      $this->tokenizer= new StreamTokenizer($stream, '<&', TRUE);
    }
    
    /**
     * Checks whether there are more elements
     *
     * @return  bool
     */
    public function hasNext() {
      return $this->tokenizer->hasMoreTokens();
    }
    
    /**
     * Returns next element
     *
     * @return  
     */
    public function next() {
      if (!$this->events) {
        if (NULL === ($t= $this->tokenizer->nextToken())) {
          if ($this->open) {
            throw new XMLFormatException('Unclosed tag');
          }
          $this->events[]= XmlEventType::$END_DOCUMENT;
        } else if ('<' === $t) {

          // <?xml ......>  => Declaration
          // <?target ...>  => Processing instruction
          // <!DOCTYPE ..>  => Doctype
          // <!-- .......>  => Comment
          // <![CDATA[ ..>  => CDATA
          // <name ......>  => Node
          // <name/>        => Empty node
          $tag= $this->tokenizer->nextToken(' >');
          if ('?xml' === $tag) {
            $this->events[]= XmlEventType::$START_DOCUMENT;
            $this->tokenizer->nextToken(' ');
          } else if ('?' === $tag{0}) {
            $this->events[]= XmlEventType::$PROCESSING_INSTRUCTION;
            $this->tokenizer->nextToken(' ');
          } else if ('!--' === $tag) {
            $this->events[]= XmlEventType::$COMMENT;
            $this->tokenizer->nextToken(' ');
          } else if ('!DOCTYPE' === $tag) {
            $this->events[]= XmlEventType::$DOCTYPE;
            $this->tokenizer->nextToken(' ');
          } else if ('![CDATA[' === $tag) {
            $this->events[]= XmlEventType::$CDATA;   // FIXME: <> allowed
            $this->tokenizer->nextToken(' ');
          } else if ('/' === $tag{0}) {
            $this->events[]= XmlEventType::$END_ELEMENT;
            $this->open--;
          } else {
            $this->events[]= XmlEventType::$START_ELEMENT;
            if ('/' === $tag{strlen($tag)- 1}) {
              $this->events[]= XmlEventType::$END_ELEMENT;
            } else {
              $this->open++;
            }
          }
          if (NULL === ($content= $this->tokenizer->nextToken('>'))) {
            throw new XMLFormatException('Unclosed tag');
          }
          if ('>' !== $content) {
            $skip= $this->tokenizer->nextToken('>');
          } else if ('/' === $content{strlen($content)- 1}) {
            $this->events[]= XmlEventType::$END_ELEMENT; 
          }
        } else if ('&' === $t) {
          $entity= $this->tokenizer->nextToken(';');
          $this->events[]= XmlEventType::$ENTITY_REF;
          $this->tokenizer->nextToken(';');
        } else {
          $this->events[]= XmlEventType::$CHARACTERS;
        }
      }
      
      return array_shift($this->events);
    }
  }
?>
