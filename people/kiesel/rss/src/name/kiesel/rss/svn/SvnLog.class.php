<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('name.kiesel.rss.svn.SvnLogEntry');

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class SvnLog extends Object {
    protected
      $entries  = NULL;
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct() {
      $this->entries= create('new util.collections.Vector<name.kiesel.rss.svn.SvnLogEntry>()');
    }
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    #[@xmlmapping(element= 'logentry', class= 'name.kiesel.rss.svn.SvnLogEntry')]
    public function addEntry($entry) {
      $this->entries[]= $entry;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function entrySize() {
      return sizeof($this->entries);
    }    
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function entry($offset) {
      return $this->entries[$offset];
    }    
  }
?>
