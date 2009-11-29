<?php
/* This class is part of the XP framework
 *
 * $Id: Classdef.class.php 11580 2009-10-11 22:41:38Z ruben $ 
 */
  $package="xp.ide.source.element";

  uses(
    'xp.ide.source.parser.InterfaceParser',
    'xp.ide.source.parser.ClassLexer',
    'xp.ide.source.Element',
    'xp.ide.source.element.IClassdef'
  );

  /**
   * Source tree reprensentation
   *
   * @purpose  IDE
   */
  class xp·ide·source·element·Interfacedef extends xp·ide·source·Element implements xp·ide·source·element·IClassdef {
    private
      $content= '',
      $name= '',
      $parents= array(),
      $methods= array();

    /**
     * Constructor
     * 
     * @param string name
     * @param string[] parents
     */
    public function __construct($name, array $parents= array()) {
      $this->name= $name;
      $this->parents= $parents;
    }

    public function parseContent() {
      $cp= new xp·ide·source·parser·InterfaceParser();
      $cp->setTopElement($this);
      $cp->parse(new xp·ide·source·parser·ClassLexer(
        new TextReader(new MemoryInputStream($this->getContent()))
      ));
    }

    /**
     * set member $methods
     * 
     * @param xp.ide.source.element.Classmethod[] methods
     */
    public function setMethods(array $methods) {
      $this->methods= $methods;
    }

    /**
     * get member $methods
     * 
     * @return xp.ide.source.element.Classmethod[]
     */
    public function getMethods() {
      return $this->methods;
    }

    /**
     * get object i of member $methods
     * 
     * @param integer i
     * @return xp.ide.source.element.Classmethod
     */
    public function getMethod($i) {
      return $this->methods[$i];
    }

    /**
     * set member $parents
     * 
     * @param string[] parents
     */
    public function setParents(array $parents) {
      $this->parents= $parents;
    }

    /**
     * get member $parents
     * 
     * @return string[]
     */
    public function getParents() {
      return $this->parents;
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
     * set member $content
     * 
     * @param string content
     */
    public function setContent($content) {
      $this->content= $content;
    }

    /**
     * get member $content
     * 
     * @return string
     */
    public function getContent() {
      return $this->content;
    }

  }

?>
