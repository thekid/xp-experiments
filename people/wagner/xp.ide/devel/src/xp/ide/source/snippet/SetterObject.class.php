<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source.snippet";

  uses(
    'lang.ClassLoader',
    'io.streams.MemoryInputStream',
    'xp.ide.source.parser.ClassFileParser',
    'xp.ide.source.parser.ClassFileLexer',
    'xp.ide.source.element.ClassFile',
    'xp.ide.source.element.Classmethodparam',
    'xp.ide.source.snippet.Setter'
  );

  /**
   * source representation
   * base object
   *
   * @purpose  IDE
   */
  class xp·ide·source·snippet·SetterObject extends xp·ide·source·snippet·Setter {
    protected function getParams($name, $type, $xtype, $dim) {
      $typename= '';
      try {
        $classBytes= ClassLoader::getDefault()->findClass($xtype)->loadClassBytes($xtype);
        $p= new xp·ide·source·parser·ClassFileParser();
        $p->setTopElement($t= new xp·ide·source·element·ClassFile());
        $p->parse(new xp·ide·source·parser·ClassFileLexer(new MemoryInputStream($classBytes)));
        $typename= $t->getClassdef()->getName();
      } catch (XPException $e) {
        $typename= 'Object';
      }
      return array(new xp·ide·source·element·Classmethodparam($name, $typename));
    }

    protected function getApidocParams($name, $type, $xtype, $dim) {
      return array(new xp·ide·source·element·ApidocDirective(sprintf('@param %s %s', $xtype, $name)));
    }
  }

?>
