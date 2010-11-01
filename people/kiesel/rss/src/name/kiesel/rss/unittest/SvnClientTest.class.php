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
    public function buildCommandAddsURLAsLastArgument() {
      $this->assertEquals(
        array('diff', 'svn://svn.xp-framework.net/xp'), 
        $this->client->buildCommand('diff')
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function buildCommandSkipsArgumentsWithNullValue() {
      $this->assertEquals(
        array('log', 'svn://svn.xp-framework.net/xp'),
        $this->client->buildCommand('log', array('limit' => NULL))
      );
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function buildCommandSupportsSwitches() {
      $this->assertEquals(
        array('log', '--verbose', 'svn://svn.xp-framework.net/xp'),
        $this->client->buildCommand('log', array('verbose'))
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
        protected function invokeSvn(array $cmd) {
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
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    protected function mockedClientOutputForDiff() {
      $client= newinstance('name.kiesel.rss.scriptlet.SvnClient', array(), '{
        protected function invokeSvn(array $cmd) {
          return "Index: branches/xp5_7/skeleton/rdbms/sybase/SybaseConnection.class.php
===================================================================
--- branches/xp5_7/skeleton/rdbms/sybase/SybaseConnection.class.php     (revision 14933)
+++ branches/xp5_7/skeleton/rdbms/sybase/SybaseConnection.class.php     (revision 14934)
@@ -62,13 +62,15 @@
         $this->handle= sybase_pconnect(
           $this->dsn->getHost(),
           $this->dsn->getUser(),
-          $this->dsn->getPassword()
+          $this->dsn->getPassword(),
+          \'iso_1\'
         );
       } else {
         $this->handle= sybase_connect(
           $this->dsn->getHost(),
           $this->dsn->getUser(),
-          $this->dsn->getPassword()
+          $this->dsn->getPassword(),
+          \'iso_1\'
         );
       }

Index: branches/xp5_7/ChangeLog
===================================================================
--- branches/xp5_7/ChangeLog    (revision 14933)
+++ branches/xp5_7/ChangeLog    (revision 14934)
@@ -6,7 +6,12 @@
 ----------------------------------
 SVN version: ?????

+Heads up!
+~~~~~~~~~
+- Set client charset in rdbms.sybase.SybaseConnection to iso_1
+  (friebe, kiesel)

+
 Version 5.7.11, released 2010-09-14
 -----------------------------------
 SVN version: 14818

          ";
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
      $this->assertEquals(new Date('2010-10-29 19:18:32+0200'), $log->entry(0)->getDate());
      $this->assertEquals('- MFH: Force sybase client charset to iso_1', $log->entry(0)->getMessage());
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function logEntryContainsLogPaths() {
      $log= $this->mockedClientOutputForLog()->queryLog(2);

      $this->assertInstanceOf('name.kiesel.rss.svn.SvnLogPaths', $log->entry(0)->getPaths());
      $this->assertEquals(2, $log->entry(0)->getPaths()->pathCount());
      
      $this->assertEquals('M', $log->entry(0)->getPaths()->pathAt(0)->getAction());
      $this->assertEquals('file', $log->entry(0)->getPaths()->pathAt(0)->getKind());
      $this->assertEquals('/branches/xp5_7/skeleton/rdbms/sybase/SybaseConnection.class.php', $log->entry(0)->getPaths()->pathAt(0)->getPath());
    }
    
    /**
     * Test
     *
     */
    #[@test]
    public function retrieveDiffForRevision() {
      $diff= $this->mockedClientOutputForDiff();
      
      $this->assertTrue(is_string($diff->queryDiffForChangeSet('14934')));
    }
  }
?>
