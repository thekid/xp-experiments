<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source.snippet";

  uses(
    'xp.ide.source.snippet.GetterName',
    'xp.ide.source.element.Classmethod',
    'xp.ide.source.element.Classmethodparam',
    'xp.ide.source.element.Apidoc',
    'xp.ide.source.element.ApidocDirective',
    'xp.ide.source.Scope',
    'xp.ide.source.Snippet'
  );

  /**
   * source representation
   * base object
   *
   * @purpose  IDE
   */
  class xp·ide·source·snippet·Getter extends xp·ide·source·Snippet {

    public function __construct($name, $type, $xtype, $dim) {
      $this->element= $this->getBaseMethod($name, $type, $xtype, $dim);
      $this->element->setApidoc(new xp·ide·source·element·Apidoc(sprintf('get member $%s'.PHP_EOL, $name)));
      $this->element->getApidoc()->setDirectives(array($this->getApidocReturn($name, $type, $xtype, $dim)));
      $this->element->setContent(sprintf('return $this->%1$s;', $name));
    }

    protected function getBaseMethod($name, $type, $xtype, $dim) {
      return new xp·ide·source·element·Classmethod(xp·ide·source·snippet·GetterName::getByType($name, $type));
    }

    protected function getApidocReturn($name, $type, $xtype, $dim) {
      return new xp·ide·source·element·ApidocDirective(sprintf('@return %s', $type));
    }

  }

?>
