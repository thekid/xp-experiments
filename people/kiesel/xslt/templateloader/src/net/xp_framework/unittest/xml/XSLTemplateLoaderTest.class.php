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
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function registerClassLoaderAndTransformFor($clpath, $path) {
      $loader= ClassLoader::getDefault()->registerPath($clpath);
      $this->transformAgainst($path);
      ClassLoader::getDefault()->removeLoader($loader);
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function transformAgainstFromXar($path) {
      $this->registerClassLoaderAndTransformFor(
        dirname(__FILE__).'/xp-xsl-inf.xar',
        $path
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function transformAgainstDefault($path) {
      $this->registerClassLoaderAndTransformFor(
        dirname(__FILE__),
        $path
      );
    }

    /**
     * Test
     *
     */
    #[@test]
    public function simpleLoading() {
      $this->transformAgainstDefault('xsl://XSL-INF/master.xsl');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleLoadingFromXar() {
      $this->transformAgainstFromXar('xsl://XSL-INF/master.xsl');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function loadingWithInclude() {
      $this->transformAgainstDefault('xsl://XSL-INF/stylesheet-including-master.xsl');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function loadingWithIncludeFromXar() {
      $this->transformAgainstFromXar('xsl://XSL-INF/stylesheet-including-master.xsl');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function loadingWithRelativeInclude() {
      $this->transformAgainstDefault('xsl://XSL-INF/sub/stylesheet-including-master.xsl');
    }

    /**
     * Test
     *
     */
    #[@test]
    public function loadingWithRelativeIncludeFromXar() {
      $this->transformAgainstDefault('xsl://XSL-INF/sub/stylesheet-including-master.xsl');
    }
  }
?>
