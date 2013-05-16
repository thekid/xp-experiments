<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Represents a pull request on GitHub
   *
   */
  class GitHubPullRequest extends Object {
    #[@type('string')]
    public $diffUrl;
    #[@type('string')]
    public $patchUrl;
    #[@type('string')]
    public $htmlUrl;

    /**
     * Creates a string representation of this issue
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s@{\n".
        " [diff   ] %s\n".
        " [patch  ] %s\n".
        "}",
        $this->getClassName(),
        $this->diffUrl, 
        $this->patchUrl
      );
    }
  }
?>
