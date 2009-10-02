<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'xp.ide.unittest.TestCase',
    'xp.ide.XpIde',
    'xp.ide.streams.EncodedInputStreamWrapper',
    'xp.ide.streams.EncodedOutputStreamWrapper',
    'io.streams.MemoryInputStream',
    'io.streams.MemoryOutputStream'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class XpIdeTest extends xp·ide·unittest·TestCase {
    private
      $ide= NULL,
      $in=  NULL,
      $out= NULL,
      $err= NULL;

    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->ide= new xp·ide·XpIde(
        $this->in= new xp·ide·streams·EncodedInputStreamWrapper(new MemoryInputStream('')),
        $this->out= new xp·ide·streams·EncodedOutputStreamWrapper(new MemoryOutputStream()),
        $this->err= new xp·ide·streams·EncodedOutputStreamWrapper(new MemoryOutputStream())
      );
    }

    /**
     * Test ide class
     *
     */
    #[@test]
    public function testComplete() {
    }

  }
?>
