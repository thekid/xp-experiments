<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.NoSuchElementException');

  /**
   * Lookup map
   *
   */
  #[@generic(self= 'K, V')]
  class Lookup extends Object {
    protected $elements= array();
   
    /**
     * Put a key/value pairt
     *
     * @param   K key
     * @param   V value
     */
    #[@generic(params= 'K, V')]
    public function put($key, $value) {
      $offset= $key instanceof Generic ? $key->hashCode() : $key;
      $this->elements[$offset]= $value;
    } 

    /**
     * Returns a value associated with a given key
     *
     * @param   K key
     * @return  V value
     * @throws  util.NoSuchElementException
     */
    public function get($key) {
      $offset= $key instanceof Generic ? $key->hashCode() : $key;
      if (!isset($this->elements[$offset])) {
        throw new NoSuchElementException('No such key '.xp::stringOf($key));
      }
      return $this->elements[$offset];
    }
  }
?>
