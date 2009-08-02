<?php
/* This class is part of the XP framework
 *
 * $Id: ClassFileInfo.class.php 11304 2009-07-31 15:56:44Z ruben $ 
 */
  $package= 'xp.ide';

  /**
   * class file info bean
   *
   * @purpose  Bean
   */
  class xp·ide·CompleteInfo extends Object {
    private
      $snippet= NULL,
      $suggestions= array();

    /**
     * constructor
     *
     * @param   xp.ide.Snippet snippet
     * @param   string[] suggestions
     */
    public function __construct($snippet, $suggestions) {
      $this->snippet= $snippet;
      $this->suggestions= $suggestions;
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
     * Set suggestions
     *
     * @param   string suggestions
     */
    public function setSuggestions($suggestions) {
      $this->suggestions= $suggestions;
    }

    /**
     * Get suggestions
     *
     * @return  string[]
     */
    public function getSuggestions() {
      return $this->suggestions;
    }
  }
?>
