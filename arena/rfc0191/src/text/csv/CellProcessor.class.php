<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  /**
   * Processes a cell's value
   *
   */
  abstract class CellProcessor extends Object {
    
    /**
     * Processes a cell value
     *
     * @param   var
     * @return  var
     */
    public abstract function process($in);
  }
?>
