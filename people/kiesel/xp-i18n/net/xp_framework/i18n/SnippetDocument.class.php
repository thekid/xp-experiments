<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('xml.meta.Unmarshaller');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  #[@xmlns('xp' => 'http://xp-framework.net/xmlns/i18n')]
  class SnippetDocument extends Object {
    protected
      $textgroups = array();

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public static function parse($string) {
      return Unmarshaller::unmarshal($string, 'net.xp_framework.i18n.SnippetDocument');
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'xp:textgroup', class= 'net.xp_framework.i18n.TextGroup')]
    public function addTextGroup(TextGroup $tg) {
      $this->textgroups[]= $tg;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      $s= $this->getClassName().'@('.$this->hashCode().') {'.PHP_EOL;
      foreach ($this->textgroups as $tg) {
        $s.= $tg->toString();
      }
      return $s.PHP_EOL;
    }
  }
?>
