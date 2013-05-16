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

    /**
     * Creates a string representation of this issue
     *
     * @return  string
     */
    public function toString() {
      return sprintf(
        "%s(#%d, %s: %s)@{\n".
        " [description  ] %s\n".
        " [dueOn        ] %s\n".
        " [closedIssues ] %s\n".
        " [openIssues   ] %s\n".
        " [createdAt    ] %s\n".
        " [creator      ] %s\n".
        "}",
        $this->getClassName(),
        $this->number, 
        $this->state,
        $this->title,
        $this->description,
        $this->dueOn,
        $this->closedIssues,
        $this->openIssues,
        xp::stringOf($this->createdAt),
        str_replace("\n", "\n  ", xp::stringOf($this->creator))
      );
    }
  }
?>
