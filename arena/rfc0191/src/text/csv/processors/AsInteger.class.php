<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */

  uses('text.csv.CellProcessor');

  /**
   * Returns cell values as an integer
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.CellProcessor
   */
  class AsInteger extends CellProcessor {

    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException
     */
    public function process($in) {
      if (1 !== sscanf($in, '%d', $out)) {
        throw new FormatException('Cannot parse "'.$in.'" into an integer');
      }
      return $this->proceed($out);
    }
  }
?>
