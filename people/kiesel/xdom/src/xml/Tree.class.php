<?php
/* This class is part of the XP framework
 *
 * $Id: Tree.class.php 12563 2008-09-29 13:31:45Z kiesel $
 */
 
  uses(
    'xml.parser.XMLParser',
    'xml.Node',
    'xml.parser.ParserCallback'
  );
 
  /**
   * The Tree class represents a tree which can be exported
   * to and imported from an XML document.
   *
   * @test     xp://net.xp_framework.unittest.xml.TreeTest
   * @see      xp://xml.parser.XMLParser
   * @purpose  Tree
   */
  class Tree extends Object {
    public 
      $root     = NULL;

    protected 
      $version  = '1.0',
      $encoding = 'iso-8859-1';
    
    /**
     * Constructor
     *
     * @param   string rootName default 'document'
     */
    public function __construct($rootName= 'document') {
      $this->root= new Node($rootName);
    }

    /**
     * Set encoding
     *
     * @param   string e encoding
     */
    public function setEncoding($e) {
      $this->encoding= $e;
    }

    /**
     * Set encoding and return this tree
     *
     * @param   string e encoding
     * @return  xml.Tree
     */
    public function withEncoding($e) {
      $this->encoding= $e;
      return $this;
    }
    
    /**
     * Retrieve encoding
     *
     * @return  string encoding
     */
    public function getEncoding() {
      return $this->encoding;
    }
    
    /**
     * Returns XML declaration
     *
     * @return  string declaration
     */
    public function getDeclaration() {
      return sprintf(
        '<?xml version="%s" encoding="%s"?>',
        $this->version,
        $this->encoding
      );
    }
    
    /**
     * Retrieve XML representation
     *
     * @param   bool indent default TRUE whether to indent
     * @return  string
     */
    public function getSource($indent= TRUE) {
      return $this->root->getSource($indent, strtolower($this->encoding), '');
    }
    
    /**
     * Add a child to this tree
     *
     * @param   xml.Element child 
     * @return  xml.Element the added child
     * @throws  lang.IllegalArgumentException in case the given argument is not a Node
     */   
    public function addChild(Element $child) {
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
    public static function fromString($string) {
      return create(new TreeParser())->parse(new StreamInputSource(new MemoryInputStream($string)));
    }
    
    /**
     * Construct an XML tree from a file.
     *
     * <code>
     *   $tree= Tree::fromFile(new File('foo.xml'));
     * </code>
     *
     * @param   io.File file
     * @param   string c default __CLASS__ class name
     * @return  xml.Tree
     * @throws  xml.XMLFormatException in case of a parser error
     * @throws  io.IOException in case reading the file fails
     */ 
    public static function fromFile($file) {
      return create(new TreeParser())->parse(new FileInputStream($file));
    }
  } 
?>
