<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'util.cmd.CommandLineParser'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class CommandLineParserTest extends TestCase {

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function setUp() {
      $this->fixture= new CommandLineParser(array('--config=./etc', '-cp', '.:skeleton/', '-V', 'some.class.name', '--verbose', 'file1', 'file2'));
    }
  
    /**
     * Test
     *
     */
    #[@test]
    public function numberOfArguments() {
      $this->assertEquals(7, $this->fixture->numberOfArguments());
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@test]
    public function arguments() {
      $this->assertEquals(
        array(
          new CommandLineArgument('config', NULL, './etc'),
          new CommandLineArgument(NULL, 'cp', '.:skeleton/'),
          new CommandLineArgument(NULL, 'V', TRUE),
          new CommandLineArgument(NULL, NULL, 'some.class.name'),
          new CommandLineArgument('verbose', NULL, TRUE),
          new CommandLineArgument(NULL, NULL, 'file1'),
          new CommandLineArgument(NULL, NULL, 'file2')
        ),
        $this->fixture->arguments()
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@test]
    public function simpleShortArg() {
      $this->assertEquals(
        new CommandLineArgument(NULL, 'V', TRUE),
        $this->fixture->argument(NULL, 'V')
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function simpleLongArg() {
      $this->assertEquals(
        new CommandLineArgument('verbose', NULL, TRUE),
        $this->fixture->argument('verbose')
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function longArgWithValue() {
      $this->assertEquals(
        new CommandLineArgument('config', NULL, './etc'),
        $this->fixture->argument('config')
      );
      
      $this->assertEquals('./etc', $this->fixture->argument('config')->value());
      $this->assertTrue($this->fixture->argument('config')->isLong());
      $this->assertFalse($this->fixture->argument('config')->isShort());
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function shortArgWithValue() {
      $this->assertEquals(
        new CommandLineArgument(NULL, 'cp', '.:skeleton/'),
        $this->fixture->argument(NULL, 'cp')
      );
      
      $this->assertEquals('.:skeleton/', $this->fixture->argument(NULL, 'cp')->value());
      $this->assertTrue($this->fixture->argument('classpath', 'cp')->isShort());
      $this->assertFalse($this->fixture->argument('classpath', 'cp')->isLong());
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function booleanShortArg() {
      $this->assertTrue($this->fixture->argument(NULL, 'V')->value());
    }
    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@test]
    public function unboundArg() {
      $this->assertEquals('some.class.name', $this->fixture->at(0)->value());
      $this->assertEquals(3, $this->fixture->at(0)->position());
      $this->assertFalse($this->fixture->at(0)->isNamed());
    }
    
    /**
     * Test
     *
     */
    #[@test, @expect('lang.IllegalArgumentException')]
    public function nonexistingArgument() {
      $this->fixture->argument('some-option', 'so');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function exists() {
      $this->assertTrue($this->fixture->exists('config', 'c'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function notExists() {
      $this->assertFalse($this->fixture->exists('some-option', 'so'));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function existsAt() {
      $this->assertTrue($this->fixture->existsAt(0));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function notExistsAt() {
      $this->assertFalse($this->fixture->existsAt(15));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function slicing() {
      $slice= $this->fixture->slice(0, $this->fixture->at(0)->position());
      $this->assertEquals(
        array(
          new CommandLineArgument('config', NULL, './etc'),
          new CommandLineArgument(NULL, 'cp', '.:skeleton/'),
          new CommandLineArgument(NULL, 'V', TRUE)
        ),
        $slice->arguments()
      );
    }
  }
?>
