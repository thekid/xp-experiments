<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.Date');

  /**
   * Fixture class for TypeDispatchTest
   *
   * @see      xp://net.xp_framework.unittest.core.TypeDispatchTest
   */
  class TypeDispatchFixture extends Object {
   
    /**
     * Serializes strings
     *
     * @param   string in
     * @param   string enc default iso-8859-1
     * @return  string
     */
    public function serialize··þstring¸þstring($in, $enc= 'iso-8859-1') {
      return 's:'.strlen($in).'@'.$enc.':'.$in.';';
    }

    /**
     * Serializes integers
     *
     * @param   int in
     * @return  string
     */
    public function serialize··þint($in) {
      return 'i:'.$in.';';
    }

    /**
     * Serializes dates
     *
     * @param   util.Date in
     * @return  string
     */
    public function serialize··Date($in) {
      return 'T:'.$in->getTime().';';
    }

    /**
     * Serializes objects
     *
     * @param   lang.Generic in
     * @return  string
     */
    public function serialize··Generic($in= NULL) {
      return ($in ? 'O:'.$in->getClassName().';' : 'N;');
    }
    
    /** (Generated) **/
    public final function serialize() {
      static $overloads= array(
        1 => array(
          'serialize··þstring¸þstring'  => array('!string'),
          'serialize··þint'             => array('!int'),
          'serialize··Date'             => array('!util.Date'),    // The order is 
          'serialize··Generic'          => array('[lang.Generic')  // relevant here!
        ),
        2 => array(
          'serialize··þstring¸þstring'  => array('!string', '!string')
        )
      );
      
      $args= func_get_args();
      foreach (@$overloads[sizeof($args)] as $method => $signature) {
        foreach ($signature as $i => $literal) {
          if (NULL === $args[$i]) {
            if ('!' === $literal{0} || !strstr($literal, '.')) continue 2;
          } else {
            if (!Type::forName(substr($literal, 1))->isInstance($args[$i])) continue 2;
          }
        }
        return call_user_func_array(array($this, $method), $args);
      }

      raise(
        'lang.MethodNotImplementedException', 
        'No overload for ['.implode(', ', array_map(array('xp', 'typeOf'), $args)).']',
        'serialize'
      );
    }
  }
?>
