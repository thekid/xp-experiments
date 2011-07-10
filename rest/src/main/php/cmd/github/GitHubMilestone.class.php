<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('cmd.github.GitHubUser');

  /**
   * Represents a milestone on GitHub
   *
   */
  class GitHubMilestone extends Object {
    #[@type('int')]
    public $number;
    #[@type('string')]
    public $title;
    #[@type('string')]
    public $url;
    #[@type('string')]
    public $description;
    #[@type('string')]
    public $state;
    #[@type('util.Date')]
    public $dueOn;
    #[@type('int')]
    public $closedIssues;
    #[@type('int')]
    public $openIssues;
    #[@type('util.Date')]
    public $createdAt;
    #[@type('cmd.github.GitHubUser')]
    public $creator;
  }
?>
