<?php
/* This class is part of the XP framework
 *
 * $Id: ClassPathScanner.class.php 11282 2009-07-22 14:44:48Z ruben $ 
 */
  $package="xp.ide.source.snippet";

  /**
   * getter name convention
   *
   * @purpose  IDE
   */
  class xp·ide·source·snippet·GetterName extends Object {

    /**
     * getter name by type
     *
     * @param string name
     * @param string type
     * @return string
     */
    public static function getByType($name, $type) {
      switch ($type) {
        case 'boolean':
        return 'is'.ucfirst($name);

        case 'array':
        case 'object':
        case 'integer':
        case 'double':
        case 'string':
        return 'get'.ucfirst($name);

        default:
        throw new IllegalArgumentException($type.': unknowen type for getter');
      }
    }

  }

?>
