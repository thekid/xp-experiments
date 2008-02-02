<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class CommandLineArgument extends Object {
    protected
      $long   = NULL,
      $short  = NULL,
      $value  = NULL,
      $pos    = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct($long, $short= NULL, $value= NULL, $position= NULL) {
      $this->long= $long;
      $this->short= $short;
      $this->value= $value;
      $this->pos= $position;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function isNamed() {
      return (isset($this->long) || isset($this->short));
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function longName() {
      return $this->long;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function shortName() {
      return $this->short;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function isLong() {
      return NULL !== $this->long;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function isShort() {
      return NULL !== $this->short;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function position() {
      return $this->pos;
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function matches($long, $short) {
      return (
        ($this->long !== NULL && $this->long === $long) ||
        ($this->short !== NULL && $this->short === $short)
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function value() {
      return $this->value;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function equals($cmp) {
      return (
        $cmp instanceof self &&
        $cmp->long == $this->long &&
        $cmp->short == $this->short &&
        $cmp->value == $this->value
      );
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      $s= $this->getClassName().'("';
      $this->long && $s.= '--'.$this->long;
      $this->short && $s.= '-'.$this->short;
      return $s.'") { "'.$this->value.'", position= '.$this->pos.' }';
    }    
  }
?>
