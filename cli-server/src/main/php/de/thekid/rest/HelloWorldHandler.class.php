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
     * @return  string
     */
    #[@webmethod(verb = 'GET', path = '/greet/{whom}')]
    public function sayHello($whom) {
      return 'Hello '.$whom;
    }
  }
?>
