<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
  $package="xp.ide.source.element";

  uses(
    'xp.ide.source.Element',
    'xp.ide.source.Scope'
  );

  /**
   * Source tree reprensentation
   *
   * @purpose  IDE
   */
  class xp·ide·source·element·Classmethod extends xp·ide·source·Element {
    private
      $name= '',
      $params= array(),
      $static= FALSE,
      $abstract= FALSE,
      $scope= NULL,
      $content= '',
      $apidoc= NULL,
      $annotations;

    public function __construct($name= '', xp·ide·source·Scope $scope= NULL) {
      $this->name= $name;
      $this->scope= NULL === $scope ? xp·ide·source·Scope::$PUBLIC : $scope;
    }

    public function equals($o) {
      if (!$o instanceof self) return FALSE;
      return $this->name === $o->getName() 
        && $this->scope === $o->getScope()
        && $this->static === $o->isStatic()
      ;
    }

    public function setAnnotations(array $annotations) {
      $this->annotations= $annotations;
    }

    public function getAnnotations() {
      return $this->annotations;
    }

    public function setName($name) {
      $this->name= $name;
    }

    public function getName() {
      return $this->name;
    }

    public function setScope(xp·ide·source·Scope $scope) {
      $this->scope= $scope;
    }

    public function getScope() {
      return $this->scope;
    }

    public function setParams($params) {
      $this->params= $params;
    }

    public function getParams() {
      return $this->params;
    }

    public function getParam($i) {
      return $this->params[$i];
    }

    public function setStatic($static) {
      $this->static= $static;
    }

    public function isStatic() {
      return $this->static;
    }

    public function setAbstract($abstract) {
      $this->abstract= $abstract;
    }

    public function isAbstract() {
      return $this->abstract;
    }

    public function setContent($content) {
      $this->content= $content;
    }

    public function getContent() {
      return $this->content;
    }

    public function setApidoc($apidoc) {
      $this->apidoc= $apidoc;
    }

    public function getApidoc() {
      return $this->apidoc;
    }
  }

?>
