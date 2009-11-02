<?php
/* This class is part of the XP framework
 *
 * $Id: Gedit.class.php 11604 2009-11-02 00:12:24Z ruben $ 
 */
  $package= 'xp.ide.info';

  /**
   * class member info
   *
   * @purpose IDE
   */
  class xp·ide·info·MemberInfo extends Object {

    private
      $final= FALSE,
      $static= FALSE,
      $scope= NULL,
      $name= '',
      $type= '';

    /**
     * Constructor
     * 
     * @param boolean final
     * @param boolean static
     * @param xp.ide.source.Scope scope
     * @param string name
     * @param string type
     */
    public function __construct($final, $static, xp·ide·source·Scope $scope, $name, $type) {
      $this->final= $final;
      $this->static= $static;
      $this->scope= $scope;
      $this->name= $name;
      $this->type= $type;
    }

    /**
     * set member $final
     * 
     * @param boolean final
     */
    public function setFinal($final) {
      $this->final= $final;
    }

    /**
     * get member $final
     * 
     * @return boolean
     */
    public function isFinal() {
      return $this->final;
    }

    /**
     * set member $static
     * 
     * @param boolean static
     */
    public function setStatic($static) {
      $this->static= $static;
    }

    /**
     * get member $static
     * 
     * @return boolean
     */
    public function isStatic() {
      return $this->static;
    }

    /**
     * set member $scope
     * 
     * @param xp.ide.source.Scope scope
     */
    public function setScope(xp·ide·source·Scope $scope) {
      $this->scope= $scope;
    }

    /**
     * get member $scope
     * 
     * @return xp.ide.source.Scope
     */
    public function getScope() {
      return $this->scope;
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

  }
?>
