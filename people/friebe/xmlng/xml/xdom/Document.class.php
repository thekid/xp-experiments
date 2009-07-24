<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.xdom.Element');

  /**
   * (Insert class' description here)
   *
   */
  class Document extends Object {
    protected $root= NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   xml.xdom.Element root
     */
    public function __construct(Element $root) {
      $this->root= $root;
    }
    
    /**
     * (Insert method's description here)
     *
     * @return  xml.xdom.Element root
     */
    public function rootElement() {
      return $this->root;
    }
  }
?>
