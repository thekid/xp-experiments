<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source";

  /**
   * source tree representation
   * base object
   *
   * @purpose  IDE
   */
  abstract class xp·ide·source·Element extends Object {
    private
      $elements= array();

    /**
     * add a subelement
     *
     * @param xp.ide.source.Element e
     */
    public function addElement(self $e) {
      $this->elements[]= $e;
    }

    /**
     * add a subelement
     *
     * @param xp.ide.source.Element[] es
     */
    public function setElements(array $es) {
      $this->elements= $es;
    }

    /**
     * get a subelement at index
     *
     * @param int i
     */
    public function getElement($i) {
      return $this->elements[$i];
    }

  }

?>
