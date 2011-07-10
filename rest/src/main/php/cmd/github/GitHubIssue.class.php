<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'cmd.github.GitHubPullRequest', 
    'cmd.github.GitHubUser',
    'cmd.github.GitHubMilestone'
  );

  /**
   * Represents an issue on GitHub
   *
   */
  class GitHubIssue extends Object {
    #[@type('int')]
    public $number;
    #[@type('string')]
    public $title;
    #[@type('string')]
    public $url;
    #[@type('string')]
    public $htmlUrl;
    #[@type('cmd.github.GitHubMilestone')]
    public $milestone;
    #[@type('cmd.github.GitHubUser')]
    public $user;
    #[@type('cmd.github.GitHubPullRequest')]
    public $pullRequest;
    #[@type('cmd.github.GitHubLabel[]')]
    public $labels;
    #[@type('string')]
    public $body;
    #[@type('cmd.github.GitHubUser')]
    public $assignee;
    #[@type('int')]
    public $comments;
    #[@type('string')]
    public $state;
    #[@type('util.Date')]
    public $closedAt;
    #[@type('util.Date')]
    public $updatedAt;
    #[@type('util.Date')]
    public $createdAt;
  }
?>
