<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'unittest.TestCase',
    'xml.DomXSLProcessor',
    'xml.xslt.XSLTemplateLoader'
  );

  /**
   * Transformation
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class XSLTemplateLoaderTest extends TestCase {

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setUp() {
      stream_wrapper_register('xsl', 'XSLTemplateLoader');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function tearDown() {
      stream_wrapper_unregister('xsl');
    }   
  
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function transformAgainst($path) {
      $proc= new DomXSLProcessor();
      $proc->setXMLBuf('<document/>');
      
      $proc->setXSLFile($path);
      $proc->run();
    }

    /**
     * Main runner method
     *
     */
    #[@test]
    public function simpleLoading() {
      $this->transformAgainst('xsl://XSL-INF/master.xsl');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function loadingWithInclude() {
      $this->transformAgainst('xsl://XSL-INF/stylesheet-including-master.xsl');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function loadingWithRelativeInclude() {
      $this->transformAgainst('xsl://XSL-INF/sub/stylesheet-including-master.xsl');
    }
  }
?>
