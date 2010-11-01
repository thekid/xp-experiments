<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'unittest.TestCase',
    'name.kiesel.rss.scriptlet.SvnClient'
  );

  /**
   * TestCase
   *
   * @see      reference
   * @purpose  purpose
   */
  class SvnClientTest extends TestCase {
    protected
      $client = NULL;
  
    /**
     * Sets up test case
     *
     */
    public function setUp() {
      $this->client= new SvnClient();
      $this->bind($this->client);
    }
    
    protected function bind($client) {
      $client->bind('svn://svn.xp-framework.net/xp');
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function buildDiffCommand() {
      $this->assertEquals(
        'diff --xml --limit=10 svn://svn.xp-framework.net/xp', 
        implode(' ', $this->client->buildCommand('diff', array('limit' => 10)))
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function mockedClientOutputForLog() {
      $client= newinstance('name.kiesel.rss.scriptlet.SvnClient', array(), '{
        public function invokeSvn(array $cmd) {
          return \'<?xml version="1.0"?>
<log>
<logentry
   revision="14934">
<author>friebe</author>
<date>2010-10-29T17:18:32.602720Z</date>
<paths>
<path
   kind="file"
   action="M">/branches/xp5_7/skeleton/rdbms/sybase/SybaseConnection.class.php</path>
<path
   kind="file"
   action="M">/branches/xp5_7/ChangeLog</path>
</paths>
<msg>- MFH: Force sybase client charset to iso_1</msg>
</logentry>
<logentry
   revision="14933">
<author>friebe</author>
<date>2010-10-29T17:18:15.189233Z</date>
<paths>
<path
   kind="file"
   action="M">/trunk/ChangeLog</path>
</paths>
<msg>- Force sybase client charset to iso_1</msg>
</logentry>
</log>\';
        }
      }');
      $this->bind($client);
      return $client;
    }    
    
    /**
     * Test
     *
     */
    #[@test]
    public function retrieveLogAsString() {
      $this->assertTrue(is_string($this->mockedClientOutputForLog()->queryLogAsString(2)));
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function retrieveLogReturnsSvnLog() {
      $log= $this->mockedClientOutputForLog()->queryLog(2);
      $this->assertInstanceOf('name.kiesel.rss.svn.SvnLog', $log);
      $this->assertEquals(2, $log->entrySize());
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function retrieveLogReturnsWrappedSvnLogEntries() {
      $log= $this->mockedClientOutputForLog()->queryLog(2);
      
      $this->assertEquals('14934', $log->entry(0)->getRevision());
      $this->assertEquals('friebe', $log->entry(0)->getAuthor());
    }
    
    
    
  }
?>
