<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'text.csv.CsvObjectReader',
    'io.streams.MemoryInputStream',
    'net.xp_framework.unittest.text.csv.Address'
  );

  /**
   * TestCase
   *
   * @see      xp://text.csv.CsvObjectReader
   */
  class CsvObjectReaderTest extends TestCase {

    /**
     * Creates a new list reader
     *
     * @param   string str
     * @return  text.csv.CsvObjectReader
     */
    protected function newReader($str) {
      return new CsvObjectReader(
        new TextReader(new MemoryInputStream($str)),
        XPClass::forName('net.xp_framework.unittest.text.csv.Address')
      );
    }
  
    /**
     * Test
     *
     */
    #[@test]
    public function readLine() {
      $in= $this->newReader('Timm;Karlsruhe;76137');
      $this->assertEquals(
        new net·xp_framework·unittest·text·csv·Address('Timm', 'Karlsruhe', '76137'), 
        $in->read(array('name', 'city', 'zip'))
      );
    }
  }
?>
