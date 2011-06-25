<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('peer.net.Record');

  /**
   * TXT
   *
   */
  class TXTRecord extends peer·net·Record {
    protected $text;
   
    /**
     * Creates a new TXT record
     *
     * @param   string name
     * @param   string text
     */
    public function __construct($name, $text) {
      parent::__construct($name);
      $this->text= $text;
    }

    /**
     * Returns text
     *
     * @return  string
     */
    public function getText() {
      return $this->text;
    }

    /**
     * Returns whether a given object is equal to this record
     *
     * @param   var cmp
     * @return  bool
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self && 
        $this->name === $this->name && 
        $this->text === $cmp->text
      );
    }

    /**
     * Creates a string representation of this record
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'("'.$this->text.'")';
    }
  }
?>
