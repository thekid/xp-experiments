<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CellProcessor');

  /**
   * Throws an exception if an empty string is encountered, returns
   * the value otherwise.
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.Optional
   * @see     xp://text.csv.CellProcessor
   */
  class Required extends CellProcessor {
    protected $next= NULL;

    /**
     * Creates a new "Required" constraint
     *
     * @param   text.csv.CellProcessor
     */
    public function __construct(CellProcessor $next= NULL) {
      $this->next= $next;
    }

    /**
     * Processes cell value
     *
     * @param   var in
     * @return  var
     * @throws  lang.FormatException
     */
    public function process($in) {
      if ('' === $in) {
        throw new FormatException('Empty values not allowed here');
      }
      return $this->next ? $this->next->process($in) : $in;
    }
  }
?>
