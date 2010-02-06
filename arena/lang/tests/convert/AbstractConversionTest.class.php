<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'cmd.SourceConverter',
    'lang.types.String'
  );

  /**
   * Abstract base class for conversion tests
   *
   * @see      xp://cmd.SourceConverter
   */
  abstract class AbstractConversionTest extends TestCase {
    protected $fixture;

    /**
     * Creates fixture
     *
     */
    public function setUp() {
      $this->fixture= new SourceConverter();
    }
    
    /**
     * Map a given name
     *
     * @param   string local
     * @param   string qualified
     */
    public function name($local, $qualified) {
      $this->fixture->nameMap[new String($local)]= new String($qualified);
    }
    
    /**
     * Assertion helper
     *
     * @param   string src
     * @param   string src
     * @param   string state
     * @throws  unittest.AssertionFailedError
     */
    protected function assertConversion($expect, $src, $state) {
      $this->assertEquals($expect, $this->fixture->convert(
        $this->name, 
        array_slice(token_get_all('<?php '.$src.'?>'), 1, -1), 
        $state
      ));
    }
  }
?>
