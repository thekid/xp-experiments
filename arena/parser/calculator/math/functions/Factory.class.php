<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  $package= 'math.functions';
  
  uses('lang.MethodNotImplementedException');

  /**
   * Functions factory
   *
   * @purpose  Factory
   */
  abstract class math·functions·Factory extends Object {

    /**
     * Factory method
     *
     * @param   string name
     * @return  math.functions.Function
     * @throws  lang.MethodNotImplementedException
     */
    public static function forName($name) {
      try {
        return Package::forName('math.functions')->loadClass(ucfirst(strtolower($name)))->newInstance();
      } catch (ClassNotFoundException $e) {
        throw new MethodNotImplementedException('Unknown function "'.$name.'"', $name);
      }
    }
  }
?>
