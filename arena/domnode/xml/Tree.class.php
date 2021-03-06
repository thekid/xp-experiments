<?php
/* This class is part of the XP framework
 *
 * $Id: Tree.class.php 9495 2007-02-26 15:26:48Z friebe $
 */
 
  uses(
    'xml.XML',
    'xml.parser.XMLParser',
    'xml.Node',
    'xml.parser.ParserCallback'
  );
 
  /**
   * The Tree class represents a tree which can be exported
   * to and imported from an XML document.
   *
   * @see      xp://xml.parser.XMLParser
   * @purpose  Tree
   */
  class Tree extends XML implements ParserCallback {
    public 
      $root     = NULL,
      $children = array(),
      $nodeType = 'node';

    public
      $_cnt,
      $_cdata,
      $_objs;
    
    /**
     * Constructor
     *
     * @param   string rootName default 'document'
     */
    public function __construct($rootName= 'document') {
      $this->root= new Node($rootName);
    }
    
    /**
     * Retrieve XML representation
     *
     * @param   bool indent default TRUE whether to indent
     * @return  string
     */
    public function getSource($indent= TRUE) {
      return (isset($this->root)
        ? $this->root->getSource($indent)
        : NULL
      );
    }
    
    /**
     * Retrieve XML representation as DOM document
     *
     * @return  php.DOMDocument
     */
    public function getDomTree() {
      $doc= new DOMDocument($this->version, $this->getEncoding());
      
      if ($this->root) {
        $doc->appendChild($this->root->getDomNode($doc));
      }
      
      return $doc;
    }
    
    /**
     * Add a child to this tree
     *
     * @param   xml.Node child 
     * @return  xml.Node the added child
     * @throws  lang.IllegalArgumentException in case the given argument is not a Node
     */   
    public function addChild(Node $child) {
      return $this->root->addChild($child);
    }

    /**
     * Construct an XML tree from a string.
     *
     * <code>
     *   $tree= Tree::fromString('<document>...</document>');
     * </code>
     *
     * @param   string string
     * @param   string c default __CLASS__ class name
     * @return  xml.Tree
     * @throws  xml.XMLFormatException in case of a parser error
     */
    public static function fromString($string, $c= __CLASS__) {
      $parser= new XMLParser();
      $tree= new $c();

      $parser->setCallback($tree);
      $parser->parse($string, 1);

      delete($parser);
      return $tree;
    }
    
    /**
     * Construct an XML tree from a file.
     *
     * <code>
     *   $tree= Tree::fromFile(new File('foo.xml');
     * </code>
     *
     * @param   io.File file
     * @param   string c default __CLASS__ class name
     * @return  xml.Tree
     * @throws  xml.XMLFormatException in case of a parser error
     * @throws  io.IOException in case reading the file fails
     */ 
    public static function fromFile($file, $c= __CLASS__) {
      $parser= new XMLParser();
      $tree= new $c();
      
      $parser->setCallback($tree);
      $parser->dataSource= $file->uri;
      $file->open(FILE_MODE_READ);
      $string= $file->read($file->size());
      $file->close();
      $parser->parse($string);

      delete($parser);
      
      return $tree;
    }
    
    /**
     * Callback function for XMLParser
     *
     * @param   resource parser
     * @param   string name
     * @param   string attrs
     * @see     xp://xml.parser.XMLParser
     */
    public function onStartElement($parser, $name, $attrs) {
      $this->_cdata= '';

      $element= new $this->nodeType($name, NULL, $attrs);
      if (!isset($this->_cnt)) {
        $this->root= $element;
        $this->_objs[1]= $element;
        $this->_cnt= 1;
      } else {
        $this->_cnt++;
        $this->_objs[$this->_cnt]= $element;
      }
    }
   
    /**
     * Callback function for XMLParser
     *
     * @param   resource parser
     * @param   string name
     * @see     xp://xml.parser.XMLParser
     */
    public function onEndElement($parser, $name) {
      if ($this->_cnt > 1) {
        $node= $this->_objs[$this->_cnt];
        $node->content= $this->_cdata;
        $parent= $this->_objs[$this->_cnt- 1];
        $parent->addChild($node);
        $this->_cdata= '';
      }
      $this->_cnt--;
    }

    /**
     * Callback function for XMLParser
     *
     * @param   resource parser
     * @param   string cdata
     * @see     xp://xml.parser.XMLParser
     */
    public function onCData($parser, $cdata) {
      $this->_cdata.= $cdata;
    }

    /**
     * Callback function for XMLParser
     *
     * @param   resource parser
     * @param   string data
     * @see     xp://xml.parser.XMLParser
     */
    public function onDefault($parser, $data) {
    }
  } 
?>
