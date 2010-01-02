<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Iterates on ZIP archive entries
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
     * @return  io.zip.ZipEntry
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
     * Goes to next
     *
     */
    public function next() { 
      $this->entry= $this->impl->nextEntry();
      $this->offset++;
    }

    /**
     * Rewinds
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
