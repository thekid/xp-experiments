<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'io.collections.IOElement'
  );

  /**
   * (Insert class' description here)
   *
   * @ext      extension
   * @see      reference
   * @purpose  purpose
   */
  class QuantCollection extends Object implements IOCollection {
    public
      $collection = NULL,
      $base       = NULL;
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function __construct(FileCollection $element, $base) {
      if (0 !== strncmp($base, $element->getURI(), strlen($base)))
        throw new IllegalArgumentException('Element '.$element->getURI().' does not belong to base '.$base);
        
      $this->collection= $element;
      $this->base= $base;
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function relativePath() {
      return substr($this->collection->getURI(), strlen($this->base)+ 1);
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getURI() {
      return $this->collection->getURI();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function toString() {
      return $this->relativePath().' @ <'.$this->base.'>';
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function getSize() {
      return $this->collection->getSize();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function createdAt() {
      return $this->collection->createdAt();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function lastAccessed() {
      return $this->collection->lastAccessed();
    }
    
    /**
     * (Insert method's description here)
     *
     * @param   
     * @return  
     */
    public function lastModified() {
      return $this->collection->lastModified();
    }
    
    public function open() {
      return $this->collection->open();
    }
    
    public function rewind() {
      return $this->collection->rewind();
    }
    
    public function next() {
      return $this->collection->next();
    }
    
    public function close() {
      return $this->collection->close();
    }
  }
?>
