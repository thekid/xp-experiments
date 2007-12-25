<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'net.xp_framework.quantum.QuantEnvironment',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class QuantEnvironmentTest extends TestCase {

    public function setUp() {
      $this->fixture= new QuantEnvironment(
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
    
    #[@test]
    public function iterateProperties() {
      $this->fixture->put('key1', 'value1');
      $this->fixture->put('key2', 'value2');
      
      $this->fixture->resetPointer();
      $this->assertEquals(array('key1', 'value1'), $this->fixture->nextProperty());
      $this->assertEquals(array('key2', 'value2'), $this->fixture->nextProperty());
      $this->assertEquals(NULL, $this->fixture->nextProperty());
    }

  }
?>
