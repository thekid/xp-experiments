<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses(
    'text.diff.source.InputSource', 
    'io.File', 
    'io.FileNotFoundException',
    'io.IOException'
  );

  /**
   * Buffered file source - reads the entire file into a buffer and 
   * keeps it there.
   *
   * @see      xp://text.diff.Difference#between
   * @purpose  Inputsource implementation
   */
  class BufferedFileSource extends Object implements InputSource {
    protected
      $file  = NULL,
      $lines = array();
      
    /**
     * Constructor
     *
     * @param   io.File file
     * @throws  io.IOException
     * @throws  io.FileNotFoundException
     */
    public function __construct(File $file) {
      if (!$file->exists()) {
        throw new FileNotFoundException('File '.$file->getURI().' does not exist');
      }
      if (FALSE === ($this->lines= file($file->getURI(), FILE_IGNORE_NEW_LINES))) {
        throw new IOException('Could not read '.$file->getURI());
      }
      $this->file= $file;
    }

    /**
     * Returns a string representation of this source
     *
     * @return  string
     */
    public function toString() {
      return $this->getClassName().'<'.$this->file->getURI().'>';
    }

    /**
     * Returns this source's name
     *
     * @return  string
     */
    public function name() {
      return $this->file->getURI();
    }

    /**
     * Returns this source's size
     *
     * @return  int
     */
    public function size() {
      return sizeof($this->lines);
    }
    
    /**
     * Returns an item at the given offset
     *
     * @param   int offset
     * @return  string
     */
    public function item($offset) {
      return $this->lines[$offset];
    }
  }
?>
