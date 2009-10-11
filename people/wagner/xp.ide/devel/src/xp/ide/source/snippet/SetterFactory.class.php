<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source.snippet";

  uses(
    'xp.ide.source.snippet.Setter',
    'xp.ide.source.snippet.SetterArray',
    'xp.ide.source.snippet.SetterObject'
  );

  /**
   * source representation
   * base object
   * 
   * @purpose  IDE
   */
  class xp搏de新ource新nippet惹etterFactory extends Object {
  
    public static function create($name, $type, $xtype, $dim) {
      switch ($type) {
        case 'array':
        return new xp搏de新ource新nippet惹etterArray($name, $type, $xtype, $dim);

        case 'integer':
        case 'double':
        case 'string':
        case 'boolean':
        return new xp搏de新ource新nippet惹etter($name, $type, $xtype, $dim);

        case 'object':
        return new xp搏de新ource新nippet惹etterObject($name, $type, $xtype, $dim);

        default:
        throw new IllegalArgumentException($type.': unknowen type for setter');
      }
    }

  }

?>
