<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'net.xp_framework.i18n.SnippetDocument'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class SnippetDocumentTest extends TestCase {
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      // TODO: Fill code that gets executed before every test method
      //       or remove this method
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function parse() {
      $document= SnippetDocument::parse(ClassLoader::getDefault()->getResource('xml/xp-app.i18n.xml'));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function marshal() {
      $document= SnippetDocument::parse(ClassLoader::getDefault()->getResource('xml/xp-app.i18n.xml'));
      $document->toXML();
    }    
  }
?>
