<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('util.NoSuchElementException', 'collections.IDictionary');

  /**
   * Lookup map
   *
   */
  #[@generic(self= 'K, V')]
  interface IDictionary {
   
    /**
     * Put a key/value pairt
     *
     * @param   K key
     * @param   V value
     */
    #[@generic(params= 'K, V')]
    public function put($key, $value);

    /**
     * Returns a value associated with a given key
     *
     * @param   K key
     * @return  V value
     * @throws  util.NoSuchElementException
     */
    #[@generic(params= 'K', return= 'V')]
    public function get($key);

    /**
     * Returns all values
     *
     * @return  V[] values
     */
    #[@generic(return= 'V[]')]
    public function values();
  }
?>
