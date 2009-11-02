<?php
/* This class is part of the XP framework
 *
 * $Id: XpIde.class.php 11593 2009-10-26 20:58:27Z ruben $ 
 */
  $package= 'xp.ide';

  /**
   * XP IDE
   *
   * @purpose Bean
   */
  class xp·ide·AccessorConfig extends Object {

    const
      ACCESS_SET= 1,
      ACCESS_GET= 2;

    private
      $name= '',
      $type= '',
      $type2= '',
      $dim= 1,
      $access= 0;

    /**
     * Constructor
     *
     * @param string name
     * @param string type
     * @param string type2
     * @param integer dim
     */
    public function __construct($name, $type, $type2, $dim) {
      $this->name= $name;
      $this->type= $type;
      $this->type2= $type2;
      $this->dim= $dim;
    }

    /**
     * set member $name
     * 
     * @param string name
     */
    public function setName($name) {
      $this->name= $name;
    }

    /**
     * get member $name
     * 
     * @return string
     */
    public function getName() {
      return $this->name;
    }

    /**
     * set member $type
     * 
     * @param string type
     */
    public function setType($type) {
      $this->type= $type;
    }

    /**
     * get member $type
     * 
     * @return string
     */
    public function getType() {
      return $this->type;
    }

    /**
     * set member $type2
     * 
     * @param string type2
     */
    public function setType2($type2) {
      $this->type2= $type2;
    }

    /**
     * get member $type2
     * 
     * @return string
     */
    public function getType2() {
      return $this->type2;
    }

    /**
     * set member $dim
     * 
     * @param integer dim
     */
    public function setDim($dim) {
      $this->dim= $dim;
    }

    /**
     * get member $dim
     * 
     * @return integer
     */
    public function getDim() {
      return $this->dim;
    }

    /**
     * add accessor to member $access
     * 
     * @param integer $acc
     */
    public function addAccess($acc) {
      $this->access |= $acc;
    }

    /**
     * test accessor is in  member $access
     * 
     * @param integer $acc
     * @return boolean
     */
    public function hasAccess($acc) {
      return (boolean)($this->access & $acc);
    }

    /**
     * get member $access
     * 
     * @return integer
     */
    public function getAccess() {
      return $this->access;
    }
  }
?>
