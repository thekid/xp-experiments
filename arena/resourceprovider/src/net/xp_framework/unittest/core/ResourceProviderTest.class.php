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
   * Test resource provider functionality
   *
   * @see      xp://lang.ResourceProvider
   * @purpose  Provide stream access for classloader-provided files
   */
  class ResourceProviderTest extends TestCase {

    /**
     * Test
     *
     */
    #[@test]
    public function translatePathWorksWithoutModule() {
      $this->assertEquals('some/where/file.xsl', ResourceProvider::getInstance()->translatePath('res://some/where/file.xsl'));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function translatePreservesTranslatedPaths() {
      $this->assertEquals('net/xp_framework/already/translated.xsl', ResourceProvider::getInstance()->translatePath('res://net/xp_framework/already/translated.xsl'));
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
    #[@test, @expect('io.FileNotFoundException')]
    public function loadingNonexistantFile() {
      $this->assertEquals('Foobar', trim(FileUtil::getContents(new File('res://one/Dummy.xsl'))));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function fileAsXslFile() {
      $added= ClassLoader::registerPath(dirname(__FILE__).'/res');
	  
      $proc= new DOMXslProcessor();
      // $proc->_base= '';
      $proc->setXslFile('res://two/ModuleOne.xsl');
      $proc->setXmlBuf('<document/>');
      $proc->run();

      $this->assertTrue(0 < strpos($proc->output(), 'I\'ve been called.'));
      $this->assertTrue(0 < strpos($proc->output(), 'I have been called, too.'));

      ClassLoader::removeLoader($added);
    }
  }
?>
