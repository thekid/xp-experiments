<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  $package= 'xp.webstart.types';

  /**
   * Represents an XNLP resource
   *
   */
  abstract class xp·webstart·types·Resource extends Object {
    protected $href;
    
    /**
     * Sets href
     *
     * @param   xp.webstart.types.URL href
     */
    #[@xmlmapping(element= '@href', class= 'xp.webstart.types.URL')]
    public function setHref(xp·webstart·types·URL $href) {
      $this->href= $href;
    }

    /**
     * Gets href
     *
     * @return  xp.webstart.types.URL
     */
    public function getHref() {
      return $this->href;
    }

    /**
     * Creates a string representation
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.xp::stringOf($this->href).'>';
    }
  }
?>
