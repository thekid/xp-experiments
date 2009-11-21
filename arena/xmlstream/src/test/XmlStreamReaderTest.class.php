<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'xml.streams.XmlStreamReader',
    'io.streams.MemoryInputStream'
  );

  /**
   * TestCase
   *
   * @see      xp://xml.streams.XmlStreamReader
   */
  class XmlStreamReaderTest extends TestCase {
  
    /**
     * Creates a
     *
     * @param     string xml
     * @return    xml.streams.XmlStreamReader
     */
    protected function newReader($xml) {
      return new XmlStreamReader(new MemoryInputStream($xml));
    }

    /**
     * Test
     *
     */
    #[@test]
    public function initiallyEmpty() {
      
    }
  }
?>
