<?php
/* This class is part of the XP framework
 *
 * $Id$
 */

  uses('text.csv.CellProcessor');

  /**
   * Throws an exception if a value is encountered more than once.
   *
   * @test    xp://net.xp_framework.unittest.text.csv.CellProcessorTest
   * @see     xp://text.csv.CellProcessor
   */
  class Unique extends CellProcessor {
    protected $next= NULL;
    protected $values= array();

    /**
     * Creates a new "Unique" constraint
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
      if (isset($this->values[$in])) {
        throw new FormatException('Value "'.$in.'" already encountered');
      }
      $this->values[$in]= TRUE;
      return $this->next ? $this->next->process($in) : $in;
    }
  }
?>
