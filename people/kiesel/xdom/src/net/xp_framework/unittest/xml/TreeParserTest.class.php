<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.parser.TreeParser',
    'xml.parser.StringInputSource',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.parser.TreeParser
   */
  class TreeParserTest extends TestCase {
    protected $fixture= NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new TreeParser();
    }
    
    /**
     * Parse xml into a tree
     *
     * @param   string xml
     * @return  xml.Tree
     */
    protected function parse($str) {
      return $this->fixture->parse(new StringInputSource($str));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function emptyTree() {
      $this->assertEquals(
        '<tree></tree>', 
        $this->parse('<tree/>')->getSource(INDENT_NONE)
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function emptyTreeWithAttribute() {
      $this->assertEquals(
        '<tree xml:lang="en"></tree>', 
        $this->parse('<tree xml:lang="en"/>')->getSource(INDENT_NONE)
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function moreComplexTree() {
      $xml= '<book><author id="1549">Timm Friebe</author><title>Unittesting</title></book>';
      $this->assertEquals(
        $xml, 
        $this->parse($xml)->getSource(INDENT_NONE)
      );
    }

    /**
     * Test typical markup
     *
     */
    #[@test]
    public function markup() {
      $xml= '<markup>This is a text with<br></br>linebreaks</markup>';
      $this->assertEquals(
        $xml, 
        $this->parse($xml)->getSource(INDENT_NONE)
      );
    }

    /**
     * Test comment
     *
     */
    #[@test]
    public function comment() {
      $xml= '<markup><!-- Comment --></markup>';
      $this->assertEquals(
        $xml, 
        $this->parse($xml)->getSource(INDENT_NONE)
      );
    }

    /**
     * Test comment
     *
     */
    #[@test]
    public function commentInside() {
      $xml= '<markup>Hello <!-- Censored -->!</markup>';
      $this->assertEquals(
        $xml, 
        $this->parse($xml)->getSource(INDENT_NONE)
      );
    }

    /**
     * Test cdata
     *
     */
    #[@test]
    public function cdata() {
      $xml= '<markup>Hello <![CDATA[&]]></markup>';
      $this->assertEquals(
        '<markup>Hello &amp;</markup>', 
        $this->parse('<markup>Hello <![CDATA[&]]></markup>')->getSource(INDENT_NONE)
      );
    }
  }
?>
