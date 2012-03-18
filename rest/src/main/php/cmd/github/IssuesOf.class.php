<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'webservices.rest.RestClient',
    'util.log.LogCategory',
    'util.log.StreamAppender',
    'cmd.github.GitHubIssue'
  );

  /**
   * Get issues for a certain repository
   *
   * @see   http://developer.github.com/v3/issues/
   */
  class IssuesOf extends Command {
    protected $request= NULL;
    protected $client= NULL;
    protected $verbose= FALSE;
    
    /**
     * Create request
     *
     */
    public function __construct() {
      $this->request= new RestRequest('/repos/{user}/{repo}/issues');
      $this->client= new RestClient('https://api.github.com');
    }
  
    /**
     * Sets user name
     *
     * @param   string user
     */
    #[@arg(position= 0)]
    public function setUser($user) {
      $this->request->addSegment('user', $user);
    }

    /**
     * Sets repository name
     *
     * @param   string repository
     */
    #[@arg(position= 1)]
    public function setRepository($repository) {
      $this->request->addSegment('repo', $repository);
    }

    /**
     * Sets whether to be verbose
     *
     */
    #[@arg]
    public function setVerbose() {
      $this->verbose= TRUE;
    }

    /**
     * Sets whether to be verbose
     *
     */
    #[@arg]
    public function setDebug() {
      $this->client->setTrace(create(new LogCategory('trace'))->withAppender(new StreamAppender($this->err->getStream())));
    }

    /**
     * Main runner method
     *
     */
    public function run() {
      $response= $this->client->execute('GitHubIssue[]', $this->request);

      if ($this->verbose) {
        $this->out->writeLine('Issue list, status ', $response->status());
        $this->out->writeLine($response->data());
      } else {
        foreach ($response->data() as $issue) {
          $this->out->writeLine('- #', $issue->number, ', ', $issue->state, ': "', $issue->title, '"');
          $this->out->writeLine('  ', $issue->user->login, ' @ ', $issue->createdAt, ' (+', $issue->comments, ')');
        }
      }
    }
  }
?>
