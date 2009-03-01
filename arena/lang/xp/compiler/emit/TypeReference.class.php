<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xp.compiler.emit.Types');

  /**
   * (Insert class' description here)
   *
   */
  class TypeReference extends Types {
    protected $name= '';
    
    /**
     * Constructor
     *
     * @param   string name
     * @param   int kind
     */
    public function __construct($name, $kind= parent::CLASS_KIND) {
      $this->name= $name;
      $this->kind= $kind;
    }
    
    /**
     * Returns name
     *
     * @return  string
     */
    public function name() {
      return $this->name;
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function literal() {
      return $this->name;
    }

    /**
     * Returns literal for use in code
     *
     * @return  string
     */
    public function kind() {
      return $this->kund;
    }
  }
?>
