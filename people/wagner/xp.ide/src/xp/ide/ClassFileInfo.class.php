<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  /**
   * class file info bean
   *
   * @purpose  Bean
   */
  class xp·ide·ClassFileInfo extends Object {
    private
      $snippet= NULL,
      $uri= '';

    /**
     * constructor
     *
     * @param   xp.ide.Snippet snippet
     * @param   string uri
     */
    public function __construct($snippet, $uri) {
      $this->snippet= $snippet;
      $this->uri= $uri;
    }

    /**
     * Set snippet
     *
     * @param   xp.ide.Snippet snippet
     */
    public function setSnippet($snippet) {
      $this->snippet= $snippet;
    }

    /**
     * Get snippet
     *
     * @return  xp.ide.Snippet
     */
    public function getSnippet() {
      return $this->snippet;
    }

    /**
     * Set uri
     *
     * @param   string uri
     */
    public function setUri($uri) {
      $this->uri= $uri;
    }

    /**
     * Get uri
     *
     * @return  string
     */
    public function getUri() {
      return $this->uri;
    }
  }
?>
