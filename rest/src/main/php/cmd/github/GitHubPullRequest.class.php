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
  }
?>
