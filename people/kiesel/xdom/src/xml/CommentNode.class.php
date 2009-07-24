<?php
/* This class is part of the XP framework
 *
 * $Id$
 *
 */

  uses(
    'xml.Element',
    'xml.XMLFormatException'
  );

  /**
   * Represents a text node
   *
   */
  class CommentNode extends Object implements Element {
    public 
      $content      = NULL;

    /**
     * Constructor
     *
     * <code>
     *   $n= new CommentNode('Hello World');
     * </code>
     *
     * @param   string content default NULL
     * @throws  xml.XMLFormatException
     */
    public function __construct($content= NULL) {
      $this->setContent($content);
    }

    /**
     * Set content
     *
     * @param   string content
     * @throws  xml.XMLFormatException in case content contains illegal characters
     */
    public function setContent($content) {

      // Scan the given string for illegal characters.
      if (is_string($content)) {  
        if (strlen($content) > ($p= strcspn($content, Node::XML_ILLEGAL_CHARS))) {
          throw new XMLFormatException(
            'Content contains illegal character at position '.$p. ' / chr('.ord($content{$p}).')'
          );
        }
      }
      
      $this->content= $content;
    }
    
    /**
     * Get content (all CDATA)
     *
     * @return  string content
     */
    public function getContent() {
      return $this->content;
    }
    
    /**
     * Retrieve XML representation
     *
     * @param   int indent default INDENT_WRAPPED
     * @param   string encoding default 'iso-8859-1'
     * @param   string inset default ''
     * @return  string XML
     */
    public function getSource($indent= INDENT_WRAPPED, $encoding= 'iso-8859-1', $inset= '') {
      $conv= 'iso-8859-1' != $encoding;
      return '<!--'.($conv
        ? iconv('iso-8859-1', $encoding, htmlspecialchars($this->content))
        : htmlspecialchars($this->content)
      ).'-->';
    }
  }
?>
