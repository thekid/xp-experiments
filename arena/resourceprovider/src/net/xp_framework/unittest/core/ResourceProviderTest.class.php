<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
  uses(
    'io.File',
    'io.FileUtil',
    'unittest.TestCase',
    'xml.DomXSLProcessor',
    'lang.ResourceProvider'
  );

  /**
   * Transformation
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class ResourceProviderTest extends TestCase {

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setUp() {
    }
    
    /**
     * (Insert method's description here)
     *
     * @param
     * @return
     */
    protected function adapter() {
      return ResourceProvider::getInstance();
    }
  
    /**
     * Test
     *
     */
    #[@test]
    public function translatePathWithVerySimplePathAndRelativeLink() {
      $this->assertEquals('Template/somefile.xsl', $this->adapter()->translatePath('res://Template/somefile.xsl'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function translatePathWorksWithoutModule() {
      $this->assertEquals('some/where/file.xsl', $this->adapter()->translatePath('res://some/where/file.xsl'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function translatePreservesTranslatedPaths() {
      $this->assertEquals('net/xp_framework/already/translated.xsl', $this->adapter()->translatePath('res://net/xp_framework/already/translated.xsl'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function loadingAsFile() {
      $added= ClassLoader::registerPath(dirname(__FILE__).'/res');
      $this->assertEquals('Foobar', trim(FileUtil::getContents(new File('res://one/Dummy.xsl'))));
      ClassLoader::removeLoader($added);
    }
 
    /**
     * Test
     *
     */
    #[@test]
    public function fileAsXslFile() {
      $added= ClassLoader::registerPath(dirname(__FILE__).'/res');
	  
      $proc= new DOMXslProcessor();
      $proc->_base= '';
      $proc->setXslFile('res://two/ModuleOne.xsl');
      $proc->setXmlBuf('<document/>');
      $proc->run();

      $this->assertTrue(0 < strpos($proc->output(), 'I\'ve been called.'));
      $this->assertTrue(0 < strpos($proc->output(), 'I have been called, too.'));

      ClassLoader::removeLoader($added);
    }
  }
?>
