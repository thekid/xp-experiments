<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CellProcessor', 'lang.Enum');

  /**
   * Formats enums as cell values
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.CellProcessor
   */
  class FormatEnum extends CellProcessor {
    
    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException
     */
    public function process($in) {
      if (!$in->getClass()->isEnum()) {
        throw new FormatException('Cannot format non-enum '.xp::stringOf($in));
      }
      return $in->name();
    }
  }
?>
