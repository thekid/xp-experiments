<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * <code>
   *   $l= EnumLookup::of(XPClass::forName('examples.coin.Coin'));
   *   echo $l['penny'];
   * </code>
   *
   * @see      reference
   * @purpose  purpose
   */
  class EnumLookup extends Object implements ArrayAccess {
    protected $map= array();

    /**
     * Constructor
     *
     * @param   lang.XPClass<? extends lang.Enum> enumClass
     */
    public function __construct(XPClass $enumClass) {
      if (!$enumClass->isSubclassOf('lang.Enum')) {
        throw new IllegalArgumentException('XPClass<? extends lang.Enum> expected');
      }
      
      foreach ($enumClass->_reflect->getStaticProperties() as $name => $member) {
        $this->map[$name]= $member;
        $this->map[$member->ordinal()]= $member;
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
