<?php
/* This class is part of the XP framework
 *
 * $Id: ClassFileInfo.class.php 11304 2009-07-31 15:56:44Z ruben $ 
 */
  $package= 'xp.ide.toggle';

  /**
   * class file response bean
   *
   * @purpose  Bean
   */
  class xp·ide·toggle·Response extends Object {
    private
      $snippet= NULL,
      $toggle= '';

    /**
     * constructor
     *
     * @param   xp.ide.text.Snippet snippet
     * @param   string toggle
     */
    public function __construct($snippet, $toggle) {
      $this->snippet= $snippet;
      $this->toggle= $toggle;
    }

    /**
     * Set snippet
     *
     * @param   xp.ide.text.Snippet snippet
     */
    public function setSnippet($snippet) {
      $this->snippet= $snippet;
    }

    /**
     * Get snippet
     *
     * @return  xp.ide.text.Snippet
     */
    public function getSnippet() {
      return $this->snippet;
    }

    /**
     * set member $toggle
     * 
     * @param string toggle
     */
    public function setToggle($toggle) {
      $this->toggle= $toggle;
    }

    /**
     * get member $toggle
     * 
     * @return string
     */
    public function getToggle() {
      return $this->toggle;
    }
  }
?>
