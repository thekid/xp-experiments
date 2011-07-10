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
    
    /**
     * Creates a string representation of this issue
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s(#%d, %s: %s)@{\n".
        " [milestone   ] %s\n".
        " [user        ] %s\n".
        " [pullRequest ] %s\n".
        " [labels      ] %s\n".
        " [body        ] %s...\n".
        " [assignee    ] %s\n".
        " [comments    ] %s\n".
        " [closedAt    ] %s\n".
        " [updatedAt   ] %s\n".
        " [createdAt   ] %s\n".
        "}",
        $this->getClassName(),
        $this->number, 
        $this->state,
        $this->title,
        str_replace("\n", "\n  ", xp::stringOf($this->milestone)),
        xp::stringOf($this->user),
        str_replace("\n", "\n  ", xp::stringOf($this->pullRequest)),
        str_replace("\n", "\n  ", xp::stringOf($this->labels)),
        addcslashes(substr($this->body, 0, 60), "\0..\17"),
        str_replace("\n", "\n  ", xp::stringOf($this->assignee)),
        $this->comments,
        xp::stringOf($this->closedAt),
        xp::stringOf($this->updatedAt),
        xp::stringOf($this->createdAt)
      );
    }
  }
?>
