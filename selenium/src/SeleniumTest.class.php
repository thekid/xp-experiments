<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'SeleniumTestSuccess', 
    'SeleniumTestFailure',
    'unittest.AssertionFailedError'
  );

  /**
   * (Insert class' description here)
   *
   */
  class SeleniumTest extends Object {
    public $name= NULL;
    public $instructions= array();  
    
    /**
     * Return a field
     *
     * @param   var browser
     * @param   string name
     * @param   string[] types
     * @return  var field
     */
    protected function fieldByName($browser, $name, array $types) {
      $fields= $browser->document->getElementsByName($name);
      
      // Verify element exists
      if (NULL === ($field= $fields->item(0))) {
        throw new AssertionFailedError('No such field', NULL, '<'.$name.'>');
      }
      
      // Verify expected type
      $fieldType= $field->getAttribute('type');
      foreach ($types as $type) {
        if ($type === $fieldType) return $field;
      }
      throw new AssertionFailedError('Unexpected type', $fieldType, $types);
    }

    /**
     * Return a link with a given text
     *
     * @param   var browser
     * @param   string text
     * @return  var link
     */
    protected function linkWithText($browser, $text) {
      $links= $browser->document->links();
      
      $found= array();
      foreach ($links as $link) {
        if ($text === $link->innerText) return $link;
        $found[]= '<a[text() = '.$link->innerText.']>';
      }
      throw new AssertionFailedError('No such link', $found, '<a[text() = '.$text.']>');
    }
    
    /**
     * Wait until browser is ready
     *
     * @see     http://msdn.microsoft.com/en-us/library/bb268229(VS.85).aspx READYSTATE enum
     * @param   var browser
     * @param   int state
     */
    protected function waitFor($browser, $state) {
      while ($state != $browser->readyState) {
        usleep(10 * 1000);
      }
    }
    
    /**
     * Run this test
     *
     * @param   var browser
     */
    public function run($browser) {
      Console::write('T ', $this->name, ' [');
      foreach ($this->instructions as $instruction) {
        $identifier= $this->name.'::'.implode('|', $instruction);
        try {
          switch ($instruction[0]) {
            case 'open': {            // open [url]
              $browser->navigate2($instruction[1]);
              $this->waitFor($browser, 4);
              break;
            }

            case 'type': {            // type [field] [value]
              $this->fieldByName($browser, $instruction[1], array('text', 'password'))->value= $instruction[2];
              break;
            }

            case 'clickAndWait': {    // clickAndWait [button], clickAndWait link=[title]
              if (2 == sscanf($instruction[1], "%[^=]=%[^\r]", $what, $spec)) {
                $field= $this->linkWithText($browser, $spec);
              } else {
                $field= $this->fieldByName($browser, $instruction[1], array('submit'));
              }
              $field->click();
              $this->waitFor($browser, 3);
              $this->waitFor($browser, 4);
              break;        
            }
            
            // (assert|verify)TextPresent [text]
            case 'verifyTextPresent': case 'assertTextPresent': {
              $text= $browser->document->body->innerText;
              if (!strstr($text, $instruction[1])) {
                throw new AssertionFailedError('Text not present', $text, $instruction[1]);
              }
              break;
            }
          }
          $results[]= new SeleniumTestSuccess($identifier);
          Console::write('.');
        } catch (Throwable $e) {
          $results[]= new SeleniumTestFailure($identifier, $e);
          Console::write('F');
        }
      }
      Console::writeLine(']');
      return $results;
    }
  }
?>
