<?php
/* This file is part of the XP framework
 *
 * $Id$
 */

  uses(
    'util.cmd.Command',
    'webservices.rest.RestClient',
    'cmd.github.GitHubIssue'
  );

  /**
   * Get issues for a certain repository
   *
   * @see   http://developer.github.com/v3/issues/
   */
  class IssuesOf extends Command {
    protected $request= NULL;
    
    /**
     * Create request
     *
     */
    public function __construct() {
      $this->request= new RestRequest('/repos/{user}/{repo}/issues');
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
     * Main runner method
     *
     */
    public function run() {
      $client= new RestClient('https://api.github.com');
      $response= $client->execute('GitHubIssue[]', $this->request);

      $this->out->writeLine($response->status(), ': ', $response->content());
    }
  }
?>
