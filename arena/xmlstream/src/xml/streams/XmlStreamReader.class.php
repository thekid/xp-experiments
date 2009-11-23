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
    'xml.streams.events.StartDocument',
    'xml.streams.events.EndDocument',
    'xml.streams.events.StartElement',
    'xml.streams.events.EndElement',
    'xml.streams.events.Characters',
    'xml.streams.events.Comment',
    'xml.streams.events.ProcessingInstruction',
    'xml.streams.events.DocTypePublic',
    'xml.streams.events.DocTypeSystem',
    'xml.streams.events.CData',
    'xml.streams.events.EntityRef'
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
    protected $encoding  = 'utf-8';
        
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
    
    public function nextToken($t, $delimiters) {
      do {
        $tok= $t->nextToken($delimiters);
      } while ($t->hasMoreTokens() && ' ' === $tok);
      return $tok;
    }
    
    /**
     * Parses attributes
     *
     * @param   text.Tokenizer t
     * @param   string end
     * @return  array<string, string>
     */
    public function parseAttributes($t, $end) {
      $attributes= array();
      
      // Parse attributes
      while ($t->hasMoreTokens() && !strspn($tok= $this->nextToken($t, '='.$end), $end)) {
        $t->nextToken('=');
        $q= $t->nextToken('\'"');
        $value= $t->nextToken($q);
        $t->nextToken($q);
        $attributes[trim($tok)]= $value;
      }
      
      // Check if we've arrived at the end
      if (NULL === $tok) {
        throw new XMLFormatException('Unclosed tag');
      }

      // Swallow end string
      while ($t->hasMoreTokens() && $tok !== $end) {
        $tok.= $t->nextToken($end);
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
          return new EndDocument();
        } 
        
        if ('<' === $t) {
          -1 === $this->open && $this->open= 0;

          // <?xml ......>  => Declaration
          // <?target ...>  => Processing instruction
          // <!DOCTYPE ..>  => Doctype
          // <!-- .......>  => Comment
          // <![CDATA[ ..>  => CDATA
          // <name ......>  => Node
          // <name>         => Node without attributes
          // <name/>        => Empty node
          $tag= $this->tokenizer->nextToken(' >');
          if ('?xml' === $tag) {
            $start= new StartDocument($this->parseAttributes($this->tokenizer, '?>'));
            $this->encoding= $start->attribute('encoding', 'utf-8');
            return $start;
          } else if ('?' === $tag{0}) {
            $this->events[]= new ProcessingInstruction(substr($tag, 1), NULL);
            $this->tokenizer->nextToken(' ');
          } else if ('!--' === $tag) {
            $this->events[]= new Comment(NULL);
            $this->tokenizer->nextToken(' ');
          } else if ('!DOCTYPE' === $tag) {
            $this->tokenizer->nextToken(' ');
            $name= $this->tokenizer->nextToken(' ');
            $this->tokenizer->nextToken(' ');
            $id= $this->tokenizer->nextToken(' ');
            if ('SYSTEM' === $id) {
              $this->events[]= new DocTypeSystem($name);
            } else if ('PUBLIC' === $id) {
              $this->events[]= new DocTypePublic($name);
            } else {
              throw new XMLFormatException('Unknown doctype id '.$id);
            }
            $this->tokenizer->nextToken(' ');
          } else if ('![CDATA[' === $tag) {
            $this->events[]= new CData(NULL);   // FIXME: <> allowed
            $this->tokenizer->nextToken(' ');
          } else if ('/' === $tag{0}) {
            $this->events[]= new EndElement();
            $this->open--;
          } else {
            $attributes= $this->parseAttributes($this->tokenizer, '>');
            if ('/' === $tag{strlen($tag)- 1}) {
              $start= new StartElement(substr($tag, 0, -1), $attributes);
              $this->events[]= new EndElement();
            } else {
              $start= new StartElement($tag, $attributes);
              $this->open++;
            }
            return $start;
          }
          if (NULL === ($content= $this->tokenizer->nextToken('>'))) {
            throw new XMLFormatException('Unclosed tag');
          }
          if ('>' !== $content) {
            $skip= $this->tokenizer->nextToken('>');
          } else if ('/' === $content{strlen($content)- 1}) {
            $this->events[]= new EndElement(); 
          }
        } else if ('&' === $t) {
          $entity= $this->tokenizer->nextToken(';');
          if (isset(self::$entities[$entity])) {
            $this->events[]= new Characters(self::$entities[$entity]);
          } else {
            $this->events[]= new EntityRef($entity);
          }
          $this->tokenizer->nextToken(';');
        } else {
          $this->events[]= new Characters(iconv($this->encoding, 'iso-8859-1', $t));
        }
      }
      
      return array_shift($this->events);
    }
  }
?>
