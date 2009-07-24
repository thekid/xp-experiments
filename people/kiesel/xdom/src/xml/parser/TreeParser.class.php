<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.parser.XMLParser', 'xml.Tree', 'xml.Node', 'xml.TextNode', 'xml.CommentNode');

  /**
   * Parses input sources into XML
   * 
   * Usage example:
   * <code>
   *   $t= create(new TreeParser())->parse(new FileInputStream(...));
   *
   *   // Work with the tree object, e.g.
   *   $t->root->addChild(new Node('document'));
   * </code>
   *
   * @see     xp://xml.Tree
   * @test    xp://net.xp_framework.unittest.xml.TreeParserTest
   */
  class TreeParser extends XMLParser {
    private $tree= NULL, $stack= array();
    
    /**
     * Parse XML data
     *
     * @param   xml.parser.InputSource data
     * @param   string source default NULL optional source identifier, will show up in exception
     * @return  xml.Tree
     * @throws  xml.XMLFormatException in case the data could not be parsed
     */
    public function parse(InputSource $data, $source= NULL) {
      $this->tree= new Tree();
      $this->tree->setEncoding($this->encoding);
      $this->callback= $this;
      $this->stack= array();
      parent::parse($data, $source);
      return $this->tree;
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
      array_unshift($this->stack, new Node($name, NULL, $attrs));
    }
   
    /**
     * Callback function for XMLParser
     *
     * @param   resource parser
     * @param   string name
     * @see     xp://xml.parser.XMLParser
     */
    public function onEndElement($parser, $name) {
      $c= array_shift($this->stack);
      if ($this->stack) {
        $this->stack[0]->addChild($c);
      } else {
        $this->tree->root= $c;
      }
    }

    /**
     * Callback function for XMLParser
     *
     * @param   resource parser
     * @param   string cdata
     * @see     xp://xml.parser.XMLParser
     */
    public function onCData($parser, $cdata) {
      $this->stack[0]->addChild(new TextNode($cdata));
    }

    /**
     * Callback function for XMLParser
     *
     * @param   resource parser
     * @param   string data
     * @see     xp://xml.parser.XMLParser
     */
    public function onDefault($parser, $data) {
      $this->stack[0]->addChild(new CommentNode(substr($data, 4, -3)));   // Trim "<!--" and "-->"
    }
  }
?>
