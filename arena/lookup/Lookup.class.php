<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Generic lookup map
   *
   * @purpose  Typesafe / chainsafe lookup
   */
  class Lookup extends Object implements ArrayAccess {
    public $__generic= array();
    protected $map= array();
    
    /**
     * Constructor
     *
     * @param   array<string, T> map
     */
    public function __construct($map) {
      if (empty($map)) {
        throw new IllegalArgumentException('Lookup map may not be empty');
      }
      $class= $this->__generic ? xp::nameOf($this->__generic[0]) : 'lang.Generic';
      foreach ($map as $key => $value) {
        $this->map[(string)$key]= cast($value, $class);
      }
    }

    /**
     * []= overloading
     *
     * @param   string key
     * @param   T value
     */
    public function offsetSet($key, $value) {
      throw new IllegalStateException('Lookup maps are immutable');
    }

    /**
     * unset([]) overloading
     *
     * @param   string key
     */
    public function offsetUnset($key) {
      throw new IllegalStateException('Lookup maps are immutable');
    }

    /**
     * isset([]) overloading
     *
     * @param   string key
     * @return  bool
     */
    public function offsetExists($key) {
      return isset($this->map[$key]);
    }
    
    /**
     * =[] overloading
     *
     * @param   string key
     * @return  T
     */
    public function offsetGet($key) {
      if (!isset($this->map[$key])) {
        raise('lang.ElementNotFoundException', 'Key "'.$key.'" does not exist');
      }
      return $this->map[$key];
    }

    /**
     * Get a member by its key
     *
     * @param   string key
     * @return  T
     */
    public function get($key) {
      if (!isset($this->map[$key])) {
        raise('lang.ElementNotFoundException', 'Key "'.$key.'" does not exist');
      }
      return $this->map[$key];
    }
  }
?>
