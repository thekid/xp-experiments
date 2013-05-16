<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Represents a user on GitHub
   *
   */
  class GitHubUser extends Object {
    #[@type('int')]
    public $id;
    #[@type('string')]
    public $login;
    #[@type('string')]
    public $url;
    #[@type('string')]
    public $avatarUrl;

    /**
     * Creates a string representation of this issue
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(#'.$this->id.': '.$this->login.')';
    }
  }
?>
