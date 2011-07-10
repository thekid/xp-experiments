<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Represents an issue on GitHub
   *
   */
  class GitHubIssue extends Object {
    public $title;
    public $url;
    public $milestone;
    public $user;
    public $pullRequest;
    public $closedAt;
    public $labels;
    public $updatedAt;
    public $createdAt;
    public $state;
    public $htmlUrl;
    public $number;
    public $body;
    public $assignee;
    public $comments;
  }
?>
