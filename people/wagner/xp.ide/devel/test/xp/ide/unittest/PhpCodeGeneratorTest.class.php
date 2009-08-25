<?php
/* This class is part of the XP framework
 *
 * $Id:$
 */

  uses(
    'xp.ide.unittest.TestCase',
    'io.streams.MemoryOutputStream',
    'xp.ide.source.Generator',
    'xp.ide.source.element.ClassFile'
  );

  /**
   * TestCase
   *
   * @purpose  Test
   */
  class PhpCodeGeneratorTest extends xp·ide·unittest·TestCase {

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->o= new MemoryOutputStream();
      $this->g= new xp·ide·source·Generator($this->o);
    }

    /**
     * Test generate php source
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function PhpCodeGenerator() {
      $this->g->visit(new Object());
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function PhpCodeGeneratorOut() {
      $this->assertSubclass(
        $this->g->getOutputStream(),
        'io.streams.OutputStream'
      );
    }

    /**
     * Test generate php source
     *
     */
    #[@test]
    public function PhpCodeGeneratorClassfile() {
      $this->g->visit(new xp·ide·source·element·ClassFile());
      $this->assertEquals("<?php\n?>", $this->o->getBytes());
    }

  }
?>
