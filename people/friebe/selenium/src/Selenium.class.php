<?php
/* This file is part of the XP framework
 *
 * $Id$
 */
 
  uses(
    'util.cmd.Command',
    'com.microsoft.com.COMObject',
    'xml.dom.Document',
    'xml.XPath',
    'io.File',
    'SeleniumTest'
  );

  /**
   * Selenium runner
   *
   * @ext      com
   */
  class Selenium extends Command {
    protected $browser= NULL;
    protected $tests= array();
    
    const TESTCASE = 'http://selenium-ide.openqa.org/profiles/test-case';
    
    /**
     * Set browser COM object
     *
     * @param   string com name
     */
    #[@arg]
    public function setBrowser($com= 'InternetExplorer.Application') {
      $this->browser= new COMObject($com);
      $this->browser->visible= FALSE;
    }

    /**
     * Set selenium file
     *
     * @param   string filename
     */
    #[@arg(position= 0)]
    public function setTest($filename) {
      $instructions= Document::fromFile(new File($filename));
      
      // Parse selenium file
      $head= $instructions->getElementsByTagName('head');
      $profile= empty($head) ? NULL : $head[0]->attribute['profile'];
      switch ($profile) {
        case self::TESTCASE: {
          $test= new SeleniumTest();
          
          // Test name
          $thead= $instructions->getElementsByTagName('thead');
          $test->name= $thead[0]->children[0]->children[0]->getContent();
          
          // Test instructions
          $tbody= $instructions->getElementsByTagName('tbody');
          foreach ($tbody[0]->children as $tr) {
            $test->instructions[]= array(
              $tr->children[0]->getContent(), 
              $tr->children[1]->getContent(),
              $tr->children[2]->getContent()
            );
          }
          $this->tests[]= $test;
          break;
        }
        
        default: throw new FormatException('Unknown selenium profile '.xp::stringOf($profile));
      }
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      foreach ($this->tests as $test) {
        Console::writeLine($test->run($this->browser));
      }
    }
    
    /**
     * Destructor. Calls "quit" on browser to ensure browser is closed.
     *
     */
    public function __destruct() {
      $this->browser && $this->browser->quit();
    }
  }
?>
