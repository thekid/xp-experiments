<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.collections.iterate.FilteredIOCollectionIterator',
    'net.xp_framework.quantum.QuantFile'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantFileIterator extends FilteredIOCollectionIterator {
    public
      $basedir  = '';

    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct(IOCollection $collection, $filter, $recursive= FALSE, $basedir) {
      parent::__construct($collection, $filter, $recursive);
      $this->basedir= $basedir;
    }
      
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function next() {
      $next= parent::next();
      
      return new QuantFile($next, $this->basedir);
    }
  }
?>
