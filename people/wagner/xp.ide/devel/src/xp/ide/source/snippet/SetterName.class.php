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
   * setter name convention
   *
   * @purpose  IDE
   */
  class xp·ide·source·snippet·SetterName extends Object {
  
    /**
     * setter name by type
     *
     * @param string name
     * @param string type
     * @return string
     */
    public static function getByType($name, $type) {
      switch ($type) {
        case 'array':
        case 'integer':
        case 'double':
        case 'string':
        case 'boolean':
        case 'object':
        return 'set'.ucfirst($name);

        default:
        throw new IllegalArgumentException($type.': unknowen type for setter');
      }
    }

  }

?>
