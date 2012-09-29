<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Simplemost REST service
   *
   */
  #[@webservice]
  class HelloWorldHandler extends Object {

    /**
     * Greet
     *
     * @param   string whom
     * @param   string case
     * @return  string
     */
    #[@webmethod(verb = 'GET', path = '/greet/{whom}?in={case}')]
    public function sayHello($whom, $case= NULL) {
      switch ($case) {
        case 'upper': return 'HELLO '.strtoupper($whom);
        case 'lower': return 'hello '.strtolower($whom);
        default: return 'Hello '.$whom;
      }
    }

    /**
     * Greet
     *
     * @param   string whom
     * @return  string
     */
    #[@webmethod(verb = 'POST', path = '/greet', inject= array('payload'))]
    public function postHello($whom) {
      return 'Hello '.$whom;
    }
  }
?>
