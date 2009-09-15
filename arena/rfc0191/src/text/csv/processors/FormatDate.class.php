<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CellProcessor', 'util.Date');

  /**
   * Formats dates as cell values
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.CellProcessor
   */
  class FormatDate extends CellProcessor {
    protected $format= '';

    /**
     * Creates a new date formatter
     *
     * @see     xp://util.Date#toString for format string composition
     * @param   string format
     */
    public function __construct($format) {
      $this->format= $format;
    }
    
    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException
     */
    public function process($in) {
      if (!$in instanceof Date) {
        throw new FormatException('Cannot format non-date '.xp::stringOf($in));
      }
      return $in->toString($this->format);
    }
  }
?>
