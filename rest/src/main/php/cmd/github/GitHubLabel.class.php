<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Represents a label on GitHub
   *
   */
  class GitHubLabel extends Object {
    #[@type('string')]
    public $name;
    #[@type('string')]
    public $color;
    #[@type('string')]
    public $url;

    /**
     * Creates a string representation of this issue
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'(#'.$this->color.': '.$this->name.')';
    }
  }
?>
