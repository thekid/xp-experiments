<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * (Insert class' description here)
   *
   */
  class ZipEntries extends Object implements Iterator {
    protected $impl= NULL;
    protected $entry= NULL;
    protected $offset= 0;
    
    /**
     * Constructor
     *
     * @param   io.zip.AbstractZipReaderImpl impl
     */
    public function __construct($impl) {
      $this->impl= $impl;
      $this->offset= 0;
    }

    /**
     * Returns current value of iteration
     *
     * @return  var
     */
    public function current() { 
      return $this->entry;
    }

    /**
     * Returns current offset of iteration
     *
     * @return  int
     */
    public function key() { 
      return $this->offset; 
    }

    /**
     * Returns current value of iteration
     *
     */
    public function next() { 
      $this->entry= $this->impl->nextEntry();
      $this->offset++;
    }

    /**
     * Returns current value of iteration
     *
     */
    public function rewind() { 
      $this->entry= $this->impl->firstEntry();
      $this->offset= 0;
    }
    
    /**
     * Checks whether iteration should continue
     *
     * @return  bool
     */
    public function valid() { 
      return NULL !== $this->entry; 
    }
    
  }
?>
