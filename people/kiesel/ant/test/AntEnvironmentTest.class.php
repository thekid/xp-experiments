<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'ant.AntEnvironment',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class AntEnvironmentTest extends TestCase {

    public function setUp() {
      $this->fixture= new AntEnvironment(
        new StringWriter(new MemoryOutputStream()),
        new StringWriter(new MemoryOutputStream())
      );
    }
    
    #[@test]
    public function defaultExclude() {
      $this->assertTrue(0 < sizeof($this->fixture->getDefaultExcludes()));
    }
    
    #[@test]
    public function modifyExcludes() {
      $size= sizeof($this->fixture->getDefaultExcludes());
      $this->fixture->addDefaultExclude('test.html');
      
      $excludes= $this->fixture->getDefaultExcludes();
      $this->assertEquals($size+ 1, sizeof($excludes));
      $this->assertEquals('test.html', $excludes[sizeof($excludes)- 1]->name);
      
      $this->fixture->removeDefaultExclude('test.html');
      $this->assertEquals($size, sizeof($this->fixture->getDefaultExcludes()));
    }

  }
?>
