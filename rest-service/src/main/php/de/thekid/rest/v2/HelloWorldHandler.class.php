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
    #[@webmethod(verb = 'GET', path = '/greet/{whom}'), @$whom: path, @$case: param]
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
    #[@webmethod(verb = 'POST', path = '/greet')]
    public function postHello($whom) {
      return 'Hello '.$whom;
    }

    /**
     * Greet
     *
     * @param   [:string] identity
     * @return  string
     */
    #[@webmethod(verb = 'POST', path = '/greet', accepts= array('text/json'))]
    public function postHelloCustom($identity) {
      return 'Hello custom '.$identity['name'];
    }
  }
?>
