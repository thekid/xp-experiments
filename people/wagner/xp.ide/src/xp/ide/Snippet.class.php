<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package= 'xp.ide';

  /**
   * Text Snippet bean
   *
   * @purpose Bean
   */
  class xp·ide·Snippet extends Object {
    private
      $position= 0,
      $text= '';

    /**
     * constructor
     *
     * @param   int position
     * @param   mixed text
     */
    public function __construct($position, $text) {
      $this->position= $position;
      $this->text= $text;
    }


    /**
     * Set position
     *
     * @param   int position
     */
    public function setPosition($position) {
      $this->position= $position;
    }

    /**
     * Get position
     *
     * @return  int
     */
    public function getPosition() {
      return $this->position;
    }

    /**
     * Set text
     *
     * @param   mixed text
     */
    public function setText($text) {
      $this->text= $text;
    }

    /**
     * Get text
     *
     * @return  mixed
     */
    public function getText() {
      return $this->text;
    }
  }
?>
