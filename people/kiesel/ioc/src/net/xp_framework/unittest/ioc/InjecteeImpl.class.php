<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('net.xp_framework.unittest.ioc.Injectee');

  /**
   * Injectee implementation
   *
   */
  class InjecteeImpl extends Object implements Injectee {

    /**
     * Returns greeting
     *
     * @return  string
     */
    public function getGreeting() {
      return 'Hello';
    }
  }
?>
