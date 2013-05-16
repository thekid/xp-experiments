<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Interface for arguments of Difference::between() method
   *
   * @see      xp://text.diff.Difference#between
   * @purpose  Source
   */
  interface InputSource {

    /**
     * Returns this source's name
     *
     * @return  string
     */
    public function name();

    /**
     * Returns this source's size
     *
     * @return  int
     */
    public function size();
    
    /**
     * Returns an item at the given offset
     *
     * @param   int offset
     * @return  string
     */
    public function item($offset);
  }
?>
