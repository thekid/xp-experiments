<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.DomXSLProcessor',
    'xml.XslAnalyzer'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class XslAnalyzerTest extends TestCase {
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->fixture= new DomXSLProcessor();
      $this->fixture->setXmlBuf('<document/>');
      $this->fixture->setXslBuf('
        <xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform"/>
      ');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function addingPreprocessAnalyzer() {
      $this->fixture->addPreprocessAnalyzer(new XslAnalyzer());
    }
    
    /**
     * Test
     *
     */
    #[@test, @expect('lang.IllegalStateException')]
    public function prerprocessAnalyzerCanInterceptTransformation() {
      $this->fixture->addPreprocessAnalyzer(newinstance('xml.XslAnalyzer', array(), '{
        public function analyze(DOMDocument $stylesheet) {
          throw new IllegalStateException("Invalid stylesheet");
        }
      }'));

      $this->fixture->run();
    }
    
    
  }
?>
