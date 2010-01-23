<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('Injectee');

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
