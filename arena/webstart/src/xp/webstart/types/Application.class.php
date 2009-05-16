<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.webstart.types';

  /**
   * Represents an XNLP application
   *
   */
  class xp·webstart·types·Application extends Object {
    protected $mainClass;
    
    /**
     * Sets mainClass
     *
     * @param   string mainClass
     */
    #[@xmlmapping(element= '@main-class')]
    public function setMainClass($mainClass) {
      $this->mainClass= $mainClass;
    }

    /**
     * Gets mainClass
     *
     * @return  string
     */
    public function getMainClass() {
      return $this->mainClass;
    }

    /**
     * Creates a string representation
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->mainClass.'>';
    }
  }
?>
