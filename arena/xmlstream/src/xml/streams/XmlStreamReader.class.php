<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.streams.InputStream',
    'text.StreamTokenizer', 
    'xml.XMLFormatException', 
    'xml.streams.XmlEventType',
    'xml.streams.events.StartDocument'
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
    protected $open      = -1;
    
    protected static $entities = array(
      'lt'    => '<',
      'gt'    => '>',
      'amp'   => '&',
      'quot'  => '"',
      'apos'  => '\'',
    );
    
    /**
     * Creates a new XML stream writer
     *
     * @param   io.streams.OutputStream stream
     */
    public function __construct(InputStream $stream) {
      $this->tokenizer= new StreamTokenizer($stream, '<&>', TRUE);
    }
    
    /**
     * Checks whether there are more elements
     *
     * @return  bool
     */
    public function hasNext() {
      return $this->events || $this->tokenizer->hasMoreTokens();
    }
    
    /**
     * Parses attributes
     *
     * @param   text.Tokenizer t
     * @return  array<string, string>
     */
    public function parseAttributes($t) {
      $attributes= array();
      while (' ' === $t->nextToken(' >')) {
        $name= $t->nextToken('=');
        $t->nextToken('=');
        $q= $t->nextToken('\'"');
        $value= $t->nextToken($q);
        $t->nextToken($q);

        $attributes[$name]= $value;
      }
      return $attributes;
    }
    
    /**
     * Returns next element
     *
     * @return  
     */
    public function next() {
      if (!$this->events) {
        if (NULL === ($t= $this->tokenizer->nextToken())) {
          if (-1 === $this->open) {
            throw new XMLFormatException('Empty document');
          } else if ($this->open) {
            throw new XMLFormatException('Unclosed tag');
          }
          return XmlEventType::$END_DOCUMENT;
        } 
        
        if ('<' === $t) {
          -1 === $this->open && $this->open= 0;

          // <?xml ......>  => Declaration
          // <?target ...>  => Processing instruction
          // <!DOCTYPE ..>  => Doctype
          // <!-- .......>  => Comment
          // <![CDATA[ ..>  => CDATA
          // <name ......>  => Node
          // <name/>        => Empty node
          $tag= $this->tokenizer->nextToken(' >');
          if ('?xml' === $tag) {
            $this->events[]= new StartDocument($this->parseAttributes($this->tokenizer));
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
          if (isset(self::$entities[$entity])) {
            $this->events[]= XmlEventType::$CHARACTERS;
          } else {
            $this->events[]= XmlEventType::$ENTITY_REF;
          }
          $this->tokenizer->nextToken(';');
        } else {
          $this->events[]= XmlEventType::$CHARACTERS;
        }
      }
      
      return array_shift($this->events);
    }
  }
?>
